<?php

namespace Virge\Cron\Command;

use Virge\Database;
use Virge\Core\Config;

/**
 * 
 * @author Michael Kramer
 */
class CleanupCommand extends \Virge\Cli\Component\Command {
    
    const COMMAND = 'virge:cron:cleanup';
    
    /**
     * Remove anything that is older than 15 minutes, we only want to keep 15 
     * minutes worth of history
     */
    public function cleanup () {
        
        $config = Config::get('cron');
        $minutes = isset($config['save_time']) ? $config['save_time'] : 15;
        
        $startDate = new \DateTime();
        $startDate->modify("-{$minutes} minutes");
        
        $sql = "DELETE FROM `virge_cron_job` WHERE `finished_on` <= ?";
        Database::query($sql, $startDate);
    }
}