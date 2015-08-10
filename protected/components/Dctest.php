<?php


class Dctest extends CComponent
{

    /**
     * User Host IP Address.
     * @var string 
     */
    public $ip;
    
     /**
     * User 16-bits (Class B) subnetwork mask.
     * @var string 
     */
    public $c_class;
    
    /**
     * User 16-bits (Class B) subnetwork mask.
     * @var string 
     */
    public $b_class;

    /**
     * Allowed failed logins during the 'failedLoginsTestDuration' period.
     * @var int Failed login attempts.
     */
    public $failedLoginsAllowed = 20; // 20 failed logins in $failedLoginsTestDuration seconds
    
    /**
     * Max number of failed logins allowed before showing a Captcha test.
     */
    public $maxLoginsBeforeCaptcha = 3;

    /**
     * Test period for login errors count, from now backwards.
     * @var int Time in seconds.
     */
    public $failedLoginsTestDuration = 300; // 5 minutes

    /**
     * Duration of the lock.
     * @var int Time in seconds.
     */
    public $lockDuration = 3600; // 30 minutes

    /**
     * Number of locks tolerated before definitive ban of the ip.
     * @var int Number of locks: 0 to disable ban.
     */
    public $locksBeforeBan = 2;
    
    /**
     * Db tables with records about failed logins, locked ips and banned ips.
     * @var string The db table name.
     */
    public $failedLoginsTable = "failed_logins";

    public $locksTable = "locked_ips";
    
    /**
     * The total number of failed logins in the test period. READ ONLY.
     * @var int 
     */
    public $failedLogins;

    /**
     * The total number of times an Ip has been locked. READ ONLY.
     * @var int 
     */
    public $timesLocked;
      /**
     * The total number of times an Ip has been locked. READ ONLY.
     * @var int 
     */
    public $locked_c = 500;
      /**
     * The total number of times an Ip has been locked. READ ONLY.
     * @var int 
     */
    
    public $locked_b = 1000;
    
    
    /**
     * The result of a query on the ip_locks table. List of lock records for the current ip.
     * @var array 
     */
    private $locks;

    /**
     * Whether the ip is locked or banned. READ ONLY.
     * @var int 
     */
    public $isLocked;

    public $isBanned;

    /**
     * Create an instance of the defender based on the ip provided.
     * @param string $ip User Host IP Address.
     */
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);

        // Get lock record for the current ip.
        $this->locks = $this->getLocks();

        // Stores data about the current ip.
        $this->timesLocked = $this->locks->rowCount;
        $this->isLocked = (boolean) $this->isLocked();
        $this->isBanned = (boolean) $this->isBanned();
        

        // Store the number of failed logins for the currenti ip.
        if (!$this->isLocked && !$this->isBanned)
        {
            $this->failedLogins = $this->countLoginErrors();
        }
        else
        {
            // If locked or banned, the number of failed login is always 1000 more than allowed.
            $this->failedLogins = $this->failedLoginsAllowed + 1000;
        }
    }

    public function needCaptcha(){
    if ($this->failedLogins >= $this->maxLoginsBeforeCaptcha){
        return true;
    }
    $class_detect = $this->countclasses();
    
    if($class_detect[0]==true||$class_detect[1]==true) return true;
    
    }
    
    /**
     * Check the session to get login failures: returns false if the user has
     * too many failures in a small time span.
     * @param array $session User's session.
     * @param int $ip User's ip.
     * @return boolean Wheter the user has the right to continue logging in.
     */
    public function isSafeIp()
    {
        if ($this->isLocked || $this->isBanned)
        {
            return false;
        }
        return true;
    }

    /**
     * Lock ip. This ip will be locked for the time defined in $this->lockDuration
     * @param string $ip
     */
    public function lockIp()
    {
        if (!$this->isLocked)
        {
            Yii::log('Now locked: ' . $this->ip, 'warning');
            return Yii::app()->db->createCommand()
                            ->insert($this->locksTable, array(
                                'ip' => $this->ip,
                                'time' => time(),
                                    )
            );
        }
        Yii::log('Already locked: ' . $this->ip, 'warning');
    }

    /**
     * Check wether the ip is currently locked.
     * @return boolean 
     */
    public function isLocked()
    {
        foreach ($this->locks as $lock)
        {
            if ($lock['time'] > time() - $this->lockDuration)
            {
                Yii::log('Ip locked? YES', 'warning');
                Yii::log('Time locked? ' . $lock['time'], 'warning');
                return true;
            }
        }
        Yii::log('Ip locked? NO', 'warning');
        return false;
    }
    
    public function countclasses(){
      $ips =  Yii::app()->db->createCommand()
                        ->select('ip')
                        ->from($this->locksTable)
                        ->query();
        
      $counter_c = 0;
      $counter_b = 0;
      $IP =new IP ();
      
      foreach ($ips as $ip) {
          
          if($IP->ip_in_range($ip,$this->ip.'/16' )){
           $counter_b++;   
          }
          if($IP->ip_in_range($ip,$this->ip.'/24' )){
           $counter_c++;   
          }
          
      }
      
      return array ($counter_b==$this->locked_b,$counter_c==$this->locked_c);
      
    }

    /**
     * Check wether the ip is banned.
     * @return int 
     */
    public function isBanned()
    {
        if ($this->timesLocked >= $this->locksBeforeBan)
        {
            Yii::log('Ip banned? YES', 'warning');
            return true;
        }
        else
        {
            Yii::log('Ip banned? NO', 'warning');
            return false;
        }
    }

    /**
     * Get lock records for the current ip.
     * @return array Array with ip
     */
    public function getLocks()
    {
        return Yii::app()->db->createCommand()
                        ->select('time')
                        ->from($this->locksTable)
                        ->where('ip=:ip', array(':ip' => $this->ip))
                        ->query();
    }

    /**
     * Get the number of failed logins for the current ip.
     * @param type $ip The ip of the current user.
     * @return int
     */
    public function countLoginErrors()
    {
        $errors = Yii::app()->db->createCommand()
                ->select('count(*) as num')
                ->from($this->failedLoginsTable)
                ->where('ip=:ip and time>:time', array(
                    ':ip' => $this->ip,
                    ':time' => time() - $this->failedLoginsTestDuration
                        )
                )
                ->queryScalar();
        return $errors;
    }

    /**
     * Save ip and time of a failed login attempt in the db and delete old records.
     * @param array $session User's session.
     * @param int $ip User's ip.
     */
    public function recordFailedLogin()
    {

        $inserted = Yii::app()->db->createCommand()
                ->insert($this->failedLoginsTable, array(
            'ip' => $this->ip,                
            'time' => time(),
                )
        );
        if ($this->failedLogins + 1 > $this->failedLoginsAllowed)
            $this->lockIp();

        Yii::log('Rows inserted: ' . $inserted, 'warning');
    }

    
    /**
     * Remove every failed login record about the current ip
     * @return integer number of rows deleted
     */
    public function removeFailedLogins()
    {
        return Yii::app()->db->createCommand()->delete($this->failedLoginsTable, 'ip=:ip', array(
                    ':ip' => $this->ip
                        )
        );
    }

}