<?php

/**
 * Mails
 *
 * @author makaiistvan
 */
class Mails {
    
    public static $salt = "3rDkIR4oN4TETbSC";
    
    public static function verificationmail($userId,$password=false){
        
      $link = "http://test.webseagull.com/verification/?id=".base64_encode($userId.':::'.self::$salt);  
      $user =  User::model()->findByPk($userId);
      $plainTextContent = "please verify your account there:\n {$link}\n ,\n Best regards,\n Dctest group.";
      
        
    // Get mailer
    $SM = Yii::app()->swiftMailer;

    // Get config
    $mailHost = 'localhost';
    $mailPort = 25; // Optional

    // New transport
    $Transport = $SM->smtpTransport($mailHost, $mailPort);

    // Mailer
   $Mailer = $SM->mailer($Transport);

    // New message
    $Message = $SM
        ->newMessage('Email verification  (test.domain.com)')
        ->setFrom(array('noreply@test.domain.com' => 'DC test'))
        ->setTo(array($user->email => $user->username))
        ->setBody($plainTextContent);

    // Send mail
    $result = $Mailer->send($Message);  
        
    }
    
    public function newpass($email,$newpass){
        
    }
    
    
}
