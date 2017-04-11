<?php

namespace Virge\Cron\Command;

use Virge\Cli\Component\Input;
use Virge\Cron\Service\JobService;
use Virge\Virge;

/**
 * Will delete rows from the database of crons that have run
 * Will look for the virge config of "save_time" in cron.php 
 * or default to things older than 15 minutes
 */
class CleanupCommand extends \Virge\Cli\Component\Command 
{
    
    const COMMAND = 'virge:cron:cleanup';
    const COMMAND_HELP = 'Cleanup old jobs from the database table';
    
    /**
     * Remove anything that is older than 15 minutes, we only want to keep 15 
     * minutes worth of history
     */
    public function run(Input $input) 
    {
        $this->getJobService()->cleanupJobs();
    }

    protected function getJobService() : JobService
    {
        return Virge::service(JobService::SERVICE_ID);
    }
}