<?php

use Virge\Cron\Service\ExpressionService;
use Virge\Cron\Service\JobService;
use Virge\Cron\Service\ScheduleService;

use Virge\Virge;

/**
 * 
 * @author Michael Kramer
 */
Virge::registerService(ExpressionService::SERVICE_ID, ExpressionService::class);
Virge::registerService(JobService::SERVICE_ID, JobService::class);
Virge::registerService(ScheduleService::SERVICE_ID, ScheduleService::class);