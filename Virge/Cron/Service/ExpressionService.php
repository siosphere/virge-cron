<?php
namespace Virge\Cron\Service;
/**
 * 
 * @author Michael Kramer
 */
class ExpressionService {
    const SERVICE_ID = 'virge.cron.service.expression';
    
    /**
     * Split the cron expression into an array
     * @param string $cronExpr
     * @return array
     */
    public function formatCronExpression($cronExpr){
		return explode(' ', $cronExpr);
	}
    
    /**
     * Is the given cron expression valid
     * @param array $cronExpr
     * @return boolean
     */
    public function isValidCronExpression($cronExpr){
        
        if(is_string($cronExpr)){
            $cronExpr = $this->formatCronExpression($cronExpr);
        }
        
		return count($cronExpr) === 5;
	}
    
    /**
     * Match the cron expression with the given number
     * @param string|int $cronExpr
     * @param int $num
     * @return boolean
     */
    public function cronMatch($cronExpr, $num){
        if ($cronExpr === '*') {
            return true;
        }
        
        //Handle Multiple
        if (strpos($cronExpr,',') !== FALSE) {
            foreach (explode(',',$cronExpr) as $expr) {
                if ($this->cronMatch($expr, $num)) {
                    return TRUE;
                }
            }
            return FALSE;
        }
        
	 	// handle modulus
        if (strpos($cronExpr,'/') !== FALSE) {
            $e = explode('/', $cronExpr);
            if (sizeof($e) !== 2 ) {
                return FALSE; //TODO: log that it is invalid
            }
            if (!is_numeric($e[1])) {
                return FALSE; // TODO: Log that it is invalid
            }
            $cronExpr = $e[0];
            $mod = $e[1];
        } else {
            $mod = 1;
        }
        
        if ($cronExpr === '*') {
            $from = 0;
            $to = 60;
        } elseif (strpos($cronExpr,'-')!==FALSE) {
        	//handle a range
            $e = explode('-', $cronExpr);
            
            if (sizeof($e) !== 2) {
               return FALSE; //TODO: log invalid expression
            }

            $from = $this->getValue($e[0]);
            $to = $this->getValue($e[1]);
        } else {
            //just regular
            $from = $this->getValue($cronExpr);
            $to = $from;
        }
        
	 	if ($from === FALSE || $to === FALSE) {
            return FALSE; //TODO: log invalid
        }
        
        return ($num >= $from) && ( $num <= $to) && ( $num % $mod == 0);
	}
    
    /**
     * Given the text value, return the integer value of a month, or day of the
     * week
     * @param type $value
     * @return int|boolean
     */
    public function getValue($value) {
       	$data = array(
            'jan'=>1,
            'feb'=>2,
            'mar'=>3,
            'apr'=>4,
            'may'=>5,
            'jun'=>6,
            'jul'=>7,
            'aug'=>8,
            'sep'=>9,
            'oct'=>10,
            'nov'=>11,
            'dec'=>12,

            'sun'=>0,
            'mon'=>1,
            'tue'=>2,
            'wed'=>3,
            'thu'=>4,
            'fri'=>5,
            'sat'=>6,
        );

        if (is_numeric($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = strtolower(substr($value,0,3));
            if (isset($data[$value])) {
                return $data[$value];
            }
        }

        return FALSE;
    }
    
    /**
     * Does the given cron expression match the given date time
     * @param array $cronExpr
     * @param \DateTime $scheduleTime
     * @return type
     */
    public function doesExpressionMatchTime($cronExpr, \DateTime $scheduleTime) {
        return $this->cronMatch($cronExpr[0], $scheduleTime->format('i'))
		 	&& $this->cronMatch($cronExpr[1], $scheduleTime->format('H'))
            && $this->cronMatch($cronExpr[2], $scheduleTime->format('d'))
            && $this->cronMatch($cronExpr[3], $scheduleTime->format('m'))
            && $this->cronMatch($cronExpr[4], $scheduleTime->format('w'));
    }
}