<?php
namespace Virge;

use Virge\Cron\Model\Job;

/**
 * 
 * @author Michael Kramer
 */
class Cron 
{
    
    protected static $_jobs = [];

    protected static $_scheduleCallbacks = [];
    
    /**
     * 
     * @param string $jobName
     * @param mixed $jobCallable
     * @param string $cronExpr
     */
    public static function add($jobName, $jobCallable, $jobArguments = [], $cronExpr = '0 0 * * *') 
    {
        $job = new Job([
            'name'          =>  $jobName,
            'callable'      =>  $jobCallable,
            'cron_expr'     =>  $cronExpr
        ]);
        $job->setArguments($jobArguments);
        return self::$_jobs[] = $job;
    }

    /**
     * Will only be called when getting potential jobs
     * you can add your Cli::add jobs within this callback
     * to improve performance
     */
    public static function onSchedule(callable $callback)
    {
        return self::$_scheduleCallbacks[] = $callback;
    }
    
    /**
     * Return all registered jobs as potential jobs
     * @return array
     */
    public static function getPotentialJobs() 
    {
        while($callback = array_pop(self::$_scheduleCallbacks)) {
            call_user_func($callback);
        }

        return self::$_jobs;
    }
}
