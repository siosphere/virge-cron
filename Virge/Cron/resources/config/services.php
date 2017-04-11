<?php

use Virge\Cron\Service\ExpressionService;
use Virge\Cron\Service\JobService;
use Virge\Cron\Service\ScheduleService;

use Virge\Virge;

/**
 * 
 * @author Michael Kramer
 */
Virge::registerService(ExpressionService::SERVICE_ID, new ExpressionService());
Virge::registerService(JobService::SERVICE_ID, new JobService());
Virge::registerService(ScheduleService::SERVICE_ID, new ScheduleService());