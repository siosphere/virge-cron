<?php

namespace Virge\Cron\Command;

use Virge\Cli\Component\Input;
use Virge\Cli;
use Virge\Cron\Service\ScheduleService;
use Virge\Virge;

/**
 * 
 * @author Michael Kramer
 */
class ScheduleCommand extends \Virge\Cli\Component\Command 
{
    
    const COMMAND = 'virge:cron:schedule';
    const COMMAND_HELP = 'Schedule cron jobs';
    
    /**
     * Schedule our potential jobs
     */
    public function run(Input $input) 
    {
        $this->getScheduleService()->scheduleJobs();
        Cli::success('Sucessfully scheduled jobs');
    }
    
    /**
     * @return ScheduleService
     */
    protected function getScheduleService() : ScheduleService
    {
        return Virge::service(ScheduleService::SERVICE_ID);
    }
}