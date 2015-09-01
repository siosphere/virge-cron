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
    public static function add($jobName, $jobCallable, $jobArguments = array(), $cronExpr = '0 0 * * *') {
        $job = new Job(array(
            'name'          =>  $jobName,
            'callable'      =>  $jobCallable,
            'cron_expr'     =>  $cronExpr
        ));
        $job->setArguments($jobArguments);
        return self::$_jobs[] = $job;
    }
    
    /**
     * Return all registered jobs as potential jobs
     * @return array
     */
    public static function getPotentialJobs() {
        return self::$_jobs;
    }
}
