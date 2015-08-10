<?php

/**
 *
 * @author stv@n <istvan.makai@gmail.com>
 */
class VerificationController extends Controller {


    public function actionIndex() {
        
        $string = base64_decode(Yii::app()->getRequest()->getParam('id'));
        $array = explode(':::', $string);
        $user = User::model()->findByPk($array[0]);
        $message  ="Verification error";
        if(Mails::$salt===$array[1]&&!empty($user))
        {
            $message = "Verification success , you can log in now !";
            $user->verified = 1;
            $user->save();
        }
        Yii::app()->user->setFlash('success', $message);
        $this->redirect(Yii::app()->homeUrl);
    }   
}
