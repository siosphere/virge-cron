<?php
namespace Virge;

use Virge\Cron\Model\Job;

/**
 * 
 * @author Michael Kramer
 */
class Cron {
    
    protected static $_jobs = array();
    
    /**
     * 
     * @param string $jobName
     * @param mixed $jobCallable
     * @param string $cronExpr
     */
    public static function add($jobName, $jobCallable, $jobArguments = [], $cronExpr = '0 0 * * *') {
        self::$_jobs[] = new Job(array(
            'name'          =>  $jobName,
            'callable'      =>  $jobCallable,
            'arguments'     =>  $jobArguments,
            'cron_expr'     =>  $cronExpr
        ));
    }
    
    /**
     * Return all registered jobs as potential jobs
     * @return array
     */
    public static function getPotentialJobs() {
        return self::$_jobs;
    }
}
