<?php

namespace Virge\Cron\Model;

/**
 * 
 * @author Michael Kramer
 */
class Job extends \Virge\ORM\Component\Model 
{
    const STATUS_OK = 'ok';
    const STATUS_FAIL = 'fail';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_QUEUED = 'queued';
    
    protected $_table = 'virge_cron_job';
    
    protected $status;

    /**
     * Get arguments
     * @return array
     */
    public function getArguments() : array
    {
        if(isset($this->arguments)) {
            $arguments = unserialize($this->arguments);
        } else {
            $arguments = false;
        }
        
        if(!$arguments) {
            return [];
        }
        
        return $arguments;
    }
    
    /**
     * Set the command line arguments by array
     * @param array $arguments
     * @return \Virge\Cron\Model\Job
     */
    public function setArguments($arguments = []) 
    {
        $this->arguments = serialize($arguments);
        return $this;
    }
}