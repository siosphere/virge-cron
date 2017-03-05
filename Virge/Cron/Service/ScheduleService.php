<?php
namespace Virge\Cron\Service;

use Virge\Cron;
use Virge\Cron\Model\Job;
use Virge\Virge;

/**
 * 
 * @author Michael Kramer
 */
class ScheduleService 
{
    
    const SERVICE_ID = 'virge.cron.service.schedule';
    
    /**
     * Schedule array of jobs from now until $endTime
     * @param type $jobs
     * @param \DateTime $endTime
     */
    public function scheduleJobs($endTime = null) 
    {
        $jobs = Cron::getPotentialJobs();
        $startTime = new \DateTime();
        if($endTime === null){
            $endTime = new \DateTime("+15 minutes");
        }
        while($startTime != $endTime){
            $startTime->modify('+1 minute');
            foreach($jobs as $job){
                $this->_scheduleJob($job, $startTime);
            }
        }
    }
    
    /**
     * Schedule a single job
     * @param Job $job
     * @param \DateTime $scheduleTime
     * @return boolean
     * @throws \Exception
     */
    protected function _scheduleJob(Job $job, \DateTime $scheduleTime) 
    {
        $cronExpr = $this->getExpressionService()->formatCronExpression($job->getCronExpr());

        if(!$this->getExpressionService()->isValidCronExpression($cronExpr)){
            return FALSE;
        }

        if($this->canSchedule($cronExpr, $scheduleTime)){
            
            $job->setScheduledFor($scheduleTime);
            if(!$job->save()) {
                throw new \Exception(sprintf("Failed to schedule job: %s, reason: %s", $job->getName(), $job->getLastError()));
            }
            $job->setId(NULL); //allow it to be saved again
            return true;
        }

        return false;
    }
    
    /**
     * Can we schedule the given job
     * @param array $cronExpr
     * @param \DateTime $scheduleTime
     * @return boolean
     */
    public function canSchedule($cronExpr, \DateTime $scheduleTime)
    {
		 return $this->getExpressionService()->doesExpressionMatchTime($cronExpr, $scheduleTime);
	}
    
    /**
     * @return ExpressionService
     */
    protected function getExpressionService() 
    {
        return Virge::service(ExpressionService::SERVICE_ID);
    }
}