<?php
namespace Virge\Cron\Service;

use Virge\Cron\Model\Job;
use Virge\Core\Config;
use Virge\Database;
use Virge\ORM\Component\Collection;
use Virge\ORM\Component\Collection\Filter;

/**
 * 
 * @author Michael Kramer
 */
class JobService 
{
    
    const SERVICE_ID = 'virge.cron.service.job';
    
    /**
     * Return jobs that are scheduled to run now (or were scheduled to run in the
     * last 10 minutes)
     * @return array
     */
    public function getRunnableJobs() {
        
        $jobs = Collection::model(Job::class)->filter(function() {
            $now = new \DateTime();
            $limit = new \DateTime();
            $limit->modify("-10 minutes"); //if any scheduled jobs are older than 10 minutes and we missed them..we missed them
            Filter::isNull('started_on');
            Filter::lte('scheduled_for', $now);
            Filter::gte('scheduled_for', $limit);
        })->setLimit(999)->asArray();
        
        return $jobs;
    }
    
    /**
     * Do we have any unprocessed jobs scheduled for anytime in the future?
     * @return boolean
     */
    public function hasJobs() 
    {
        
        $count = 0;
        
        Collection::model(Job::class)->filter(function() {
            $now = new \DateTime();
            Filter::isNull('started_on');
            Filter::gte('scheduled_for', $now);
        })->count($count);
        
        return $count > 0;
    }

    public function cleanupJobs()
    {
        $config = Config::get('cron');
        $minutes = isset($config['save_time']) ? $config['save_time'] : 15;
        
        $startDate = new \DateTime();
        $startDate->modify("-{$minutes} minutes");
        
        $sql = "DELETE FROM `virge_cron_job` WHERE `finished_on` <= ?";
        Database::query($sql, $startDate);
    }
}