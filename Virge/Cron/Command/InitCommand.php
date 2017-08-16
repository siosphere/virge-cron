<?php

namespace Virge\Cron\Command;

use Virge\Cli\Component\Input;
use Virge\Cli;
use Virge\Core\Config;

/**
 * 
 * @author Michael Kramer
 */
class InitCommand extends \Virge\Cli\Component\Command 
{
    
    const COMMAND = 'virge:cron:init';
    const COMMAND_HELP = 'Setup the cron database table';
    
    /**
     * Setup table to hold our migrations
     */
    public function run(Input $input) 
    {
        Cli::important("Virge::Cron");
        
        $command = new Input();
        $command->setCommand('virge:db:schema:commit')
        ->setOptions([
            'dir' => new Option('dir', Config::path("Virge\\Cron@resources/setup/db/")),
        ]);

        Cli::execute($command);
        Cli::success('Successfully initialized cron table');
    }
}