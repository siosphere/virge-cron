<?php

namespace Virge\Cron\Command;

use Virge\Cli\Component\Process;
use Virge\Core\Config;
use Virge\Cron\Service\JobService;
use Virge\Cron\Service\ScheduleService;
use Virge\Virge;

/**
 * Supervise and execute the crons we have in the table that can currently be run
 * Each cron runs in it's own process
 * @author Michael Kramer
 */
class SupervisorCommand extends \Virge\Cli\Component\Command 
{
    
    const COMMAND = 'virge:cron:supervisor';
    
    protected $workers = [];
    
    /**
     * Remove anything that is older than 15 minutes, we only want to keep 15 
     * minutes worth of history
     */
    public function run()
    {
        if($this->instanceAlreadyRunning()){
            return $this->terminate();
        }
        
        $this->path = Config::get('base_path');
        $this->command = WorkerCommand::COMMAND;
        
        if(!$this->getJobService()->hasJobs()){
            $this->getScheduleService()->scheduleJobs();
        }
        
        $this->startJobs();
    }
    
    /**
     * @deprecated
     */
    public function start() 
    {
        $this->run();
    }
    
    protected function startJobs() 
    {
        
        $jobs = $this->getJobService()->getRunnableJobs();
        
        foreach($jobs as $job) {
            //stay alive until all processess have exited
            $this->workers[] = new Process("php -f {$this->path}vadmin.php {$this->command} {$job->getId()}");
        }
        
        while(count($this->workers) > 0){
            $this->_filterWorkers();
            sleep(1);
        }
    }
    
    /**
     * Filter our currently running workers, see if we need to rateLimit anything
     */
    protected function _filterWorkers() 
    {
        $filteredWorkers = array_filter($this->workers, function($worker) {
            return !$worker->isFinished();
        });
        
        $this->workers = $filteredWorkers;
    }
    
    /**
     * @return JobService
     */
    protected function getJobService() : JobService
    {
        return Virge::service(JobService::SERVICE_ID);
    }
    
    /**
     * @return ScheduleService
     */
    protected function getScheduleService() : ScheduleService
    {
        return Virge::service(ScheduleService::SERVICE_ID);
    }
}