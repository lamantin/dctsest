<?php

/**
 * @author stv@n <istvan.makai@gmail.com>
 */

/**
 *
 * @author stvan
 */
class RegisterForm extends CFormModel {

    public $username;
    public $email;
    public $password;
    public $retypepasswordpassword;
   
    public function tableName() {
        return 'user';
    }

    public function rules() {
        return array(
            array('username,email, password, retypepasswordpassword', 'required'),
            array('username, email, password, retypepasswordpassword', 'length', 'max' => 200),
          
            array('email', 'email', 'message' => 'Please insert valid Email'),
            array('retypepasswordpassword', 'required', 'on' => 'Register'),
            array('password', 'compare', 'compareAttribute' => 'retypepasswordpassword'),
            array('password','ext.SPasswordValidator.SPasswordValidator', 'preset' => 'relax'),
            array('id, username, email', 'safe', 'on' => 'search'),);
    }

}

