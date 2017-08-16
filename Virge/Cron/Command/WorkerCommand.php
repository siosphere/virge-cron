<?php
namespace Virge\Cron\Command;

use Virge\Cli\Component\Process;
use Virge\Cli\Component\Input;
use Virge\Core\Config;
use Virge\Cron\Model\Job;

/**
 * 
 * @author Michael Kramer
 */
class WorkerCommand 
{
    
    const COMMAND = 'virge:cron:worker';
    const COMMAND_HELP = 'Used to run a given job';
    const COMMAND_USAGE = 'virge:cron:worker [jobId]';
    
    protected $path;
    
    /**
     * Do a job
     * @param int $jobId
     * @throws \InvalidArgumentException
     */
    public function run(Input $input) 
    {
        $jobId = $input->getArgument(0);
        $job = new Job();
        if(!$job->load($jobId)){
            throw new \InvalidArgumentException(sprintf("No job found for Job ID: %s", $jobId));
        }
        $job->setStartedOn(new \DateTime);
        $job->setStartedBy(get_current_user());
        $job->save();
        
        $this->path = Config::get('base_path');
        
        $arguments = $job->getArguments();
        $argumentString = implode(" ", array_map(function($argument){
            return "\"{$argument}\"";
        }, $arguments));
        
        $command = new Process("{$this->path}vadmin {$job->getCallable()} {$argumentString}");
        
        while(!$command->isFinished()){
            sleep(1);
        }
        
        $job->setFinishedOn(new \DateTime);
        $job->setSummary($command->getOutput());
        $job->save();
    }

    /**
     * @deprecated
     */
    public function work($jobId)
    {
        $this->run($jobId);
    }
}