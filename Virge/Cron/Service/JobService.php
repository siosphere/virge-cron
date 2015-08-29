<?php
namespace Virge\Cron\Service;

use Virge\ORM\Component\Collection;
use Virge\ORM\Component\Collection\Filter;

/**
 * 
 * @author Michael Kramer
 */
class JobService {
    
    const SERVICE_ID = 'virge.cron.service.job';
    
    /**
     * Return jobs that are scheduled to run now (or were scheduled to run in the
     * last 10 minutes)
     * @return array
     */
    public function getRunnableJobs() {
        
        $jobs = Collection::model('\\Virge\\Cron\\Model\\Job')->filter(function() {
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
    public function hasJobs() {
        
        $count = 0;
        
        Collection::model('\\Virge\\Cron\\Model\\Job')->filter(function() {
            Filter::isNull('started_on');
        })->count($count);
        
        return $count > 0;
    }
}