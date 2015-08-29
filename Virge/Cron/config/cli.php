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
Cli::add(CleanupCommand::COMMAND, "\\Virge\\Cron\\Command\\CleanupCommand", "cleanup");
Cli::add(InitCommand::COMMAND, "\\Virge\\Cron\\Command\\InitCommand", "init");
Cli::add(ScheduleCommand::COMMAND, "\\Virge\\Cron\\Command\\ScheduleCommand", "schedule");
Cli::add(SupervisorCommand::COMMAND, "\\Virge\\Cron\\Command\\SupervisorCommand", "start");
Cli::add(WorkerCommand::COMMAND, "\\Virge\\Cron\\Command\\WorkerCommand", "work");
