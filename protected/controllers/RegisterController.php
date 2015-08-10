<?php

/**
 * Registering
 *
 * @author stv@n <istvan.makai@gmail.com>
 */
class RegisterController extends Controller {

    public function actionIndex() {
        $errors = array();
        $model = new RegisterForm;
        $newUser = new User;


        if (isset($_POST['RegisterForm'])) {

            $model->attributes = $_POST['RegisterForm'];
            if ($model->validate()) {
                $newUser->username = $model->username;
                $newUser->email = $model->email;
                $newUser->password = md5($model->password);


                if ($newUser->save()) {
                    //verification email//
                    Yii::app()->user->setFlash('success', "Check your mailbox to verify your mail address");
                    Mails::verificationmail($newUser->id, $model->password);
                    // validate user input and redirect to the previous page if valid

                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $errors = $newUser->getErrors() ? : $errors;
        }
        $this->render('index', array('errors' => $errors, 'model' => $model));
    }

}
