<?php

/**
 * Recover password
 *
 * @author stv@n <istvan.makai@gmail.com>
 */
class RecoverController extends Controller {

    public function actionIndex() {
        $message = null;
        if (Yii::app()->request->isPostRequest) {

            $email = $_POST['submitted']["email"];


            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $result = User::model()->findByAttributes(array('email' => $email));
                if ($result) {
                    User::makenewPassword($result['id']);
                    $message = "New password sent to {$email}";
                }
                if (empty($result))
                    $message = "$email is not in database";
            } else {
                $message = ("{$email} is not a valid email address");
            }
        }
        $this->render('index', array('message' => $message));
    }

}
