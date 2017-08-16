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

    protected static $_inited = false;

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
        self::init();

        return self::$_jobs;
    }

    /**
     * Run callbacks for initing of cron scheduled jobs
     */
    protected static function init()
    {
        if(self::$_inited) {
            return;
        }

        while($callback = array_pop(self::$_scheduleCallbacks)) {
            call_user_func($callback);
        }

        self::$_inited = true;
    }
}
