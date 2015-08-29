<?php

use Virge\Cron;
use Virge\Cron\Command\CleanupCommand;
use Virge\Cron\Command\ScheduleCommand;

/**
 * 
 * @author Michael Kramer
 */

Cron::add('cron/cleanup', CleanupCommand::COMMAND, array(), '*/15 * * * *');
Cron::add('cron/schedule', ScheduleCommand::COMMAND, array(), '*/15 * * * *');