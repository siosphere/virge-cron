<?php

use Virge\Cli;

use Virge\Cron\Command\CleanupCommand;
use Virge\Cron\Command\InitCommand;
use Virge\Cron\Command\ScheduleCommand;
use Virge\Cron\Command\SupervisorCommand;
use Virge\Cron\Command\WorkerCommand;
/**
 * 
 * @author Michael Kramer
 */
Cli::add(CleanupCommand::COMMAND, CleanupCommand::class);
Cli::add(InitCommand::COMMAND, InitCommand::class);
Cli::add(ScheduleCommand::COMMAND, ScheduleCommand::class);
Cli::add(SupervisorCommand::COMMAND, SupervisorCommand::class);
Cli::add(WorkerCommand::COMMAND, WorkerCommand::class);
