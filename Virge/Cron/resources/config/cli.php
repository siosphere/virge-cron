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
Cli::add(CleanupCommand::COMMAND, CleanupCommand::class)
    ->setHelpText(CleanupCommand::COMMAND_HELP);

Cli::add(InitCommand::COMMAND, InitCommand::class)
    ->setHelpText(InitCommand::COMMAND_HELP);

Cli::add(ScheduleCommand::COMMAND, ScheduleCommand::class)
    ->setHelpText(ScheduleCommand::COMMAND_HELP);

Cli::add(SupervisorCommand::COMMAND, SupervisorCommand::class)
    ->setHelpText(SupervisorCommand::COMMAND_HELP);

Cli::add(WorkerCommand::COMMAND, WorkerCommand::class)
    ->setHelpText(WorkerCommand::COMMAND_HELP)
    ->setUsage(WorkerCommand::COMMAND_USAGE);
