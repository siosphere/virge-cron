<?php

namespace Virge\Cron\Command;

use Virge\Cli;
use Virge\Core\Config;

/**
 * 
 * @author Michael Kramer
 */
class InitCommand extends \Virge\Cli\Component\Command 
{
    
    const COMMAND = 'virge:cron:init';
    
    /**
     * Setup table to hold our migrations
     */
    public function run() 
    {
        Cli::output("Virge::Cron");
        include_once Config::path("Virge\\Cron@resources/setup/db/cron_job.php");
        Cli::output('Successfully initialized cron table');
    }
}