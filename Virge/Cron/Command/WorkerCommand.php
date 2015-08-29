<?php
namespace Virge\Cron\Command;

use Virge\Cli\Component\Process;
use Virge\Cron\Model\Job;

/**
 * 
 * @author Michael Kramer
 */
class WorkerCommand {
    
    const COMMAND = 'virge:cron:worker';
    
    /**
     * Do a job
     * @param int $jobId
     * @throws \InvalidArgumentException
     */
    public function work($jobId) {
        
        $job = new Job();
        if(!$job->load($jobId)){
            throw new \InvalidArgumentException(sprintf("No job found for Job ID: %s", $jobId));
        }
        $job->setStartedOn(new \DateTime);
        $job->setStartedBy(get_current_user());
        $job->save();
        
        $arguments = $job->getArguments();
        $argumentString = implode(" ", array_map(function($argument){
            return "\"{$argument}\"";
        }, $arguments));
        
        $command = new Process("php -f {$this->path}vadmin.php {$job->getCallable()} {$argumentString}");
        
        while(!$command->isFinished()){
            sleep(1);
        }
        
        $job->setFinishedOn(new \DateTime);
        $job->setSummary($command->getOutput());
        $job->save();
    }
}