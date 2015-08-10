<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/default';
   
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $title = "";
   
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function hashPassword($phrase) {
        return hash('md5', $phrase);
    }



    

    public function jsonRender($data=array(),$code=403,$return=false) {
        $this->layout = false;
        header('Content-type: application/json; charset=UTF-8');
         if (!empty($data)) {
                $code   =  200;
                $return = true;
            }
            $response = array(
                'data' => $data,
                'code' => $code,
                'return' => $return
            );

            echo json_encode($response);
            Yii::app()->end();
    }

    /**
     * To array('recipient@example.com' => 'Recipient Name')
     *
     */
    public function sendmail($subject,$to=array(),$htmlview=false,$textonly = true,$message,$from=false){

        $sender=$from?:array("noreply@webseagull.com"=>"tester");
        if($textonly==false) {
         $content = $this->render($htmlview, array(
        'message' => $message,
    ), true);
        }
    
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
        ->newMessage($subject)
        ->setFrom($sender)
        ->setTo($to)
        ->setBody($message);
         if($textonly==false) $SM->addPart($content, 'text/html');
    // Send mail
   $return = $Mailer->send($Message);
    return true;
    }

}
