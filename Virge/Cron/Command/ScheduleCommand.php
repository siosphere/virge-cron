<?php

namespace Virge\Cron\Command;

use Virge\Cli;
use Virge\Cron\Service\ScheduleService;
use Virge\Virge;

/**
 * 
 * @author Michael Kramer
 */
class ScheduleCommand extends \Virge\Cli\Component\Command {
    
    const COMMAND = 'virge:cron:schedule';
    
    /**
     * Schedule our potential jobs
     */
    public function schedule () {
        $this->getScheduleService()->scheduleJobs();
        Cli::output('Sucessfully scheduled jobs');
    }
    
    /**
     * @return ScheduleService
     */
    protected function getScheduleService() {
        return Virge::service(ScheduleService::SERVICE_ID);
    }
}