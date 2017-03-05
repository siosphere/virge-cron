<?php

use Virge\Cron;
use Virge\Cron\Command\ScheduleCommand;

Cron::add('cron/schedule', ScheduleCommand::COMMAND, array(), '*/15 * * * *');