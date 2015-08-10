<?php

/**
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $verified
 * @author stv@n <istvan.makai@gmail.com>
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return static the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, email', 'required'),
            array('username, password, email', 'length', 'max' => 128),
            array('email', 'unique', 'message' => 'Email already exists!'),
            array('username', 'unique', 'message' => 'User already exists!'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Id',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'verified' => 'Verified'
        );
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username);
        $criteria->compare('password', $this->password);
        $criteria->compare('email', $this->email);
        $criteria->compare('verified', $this->verified);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function makenewPassword($id) {
        $new_password = $this->randomPassword();
        $user = $this->findByPk($id);
        $user->password = md5($new_password);
        $user->save();
        
        //mail
        $plainTextContent = "You sent a new password request from our site.\n Your new password is:\n {$new_password}\n ,and with this email you can log in to our system.\n Best regards,\n Armibet group.";

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
                ->newMessage('Password Recovery (test.webseagull.com)')
                ->setFrom(array('noreply@test.webseagull.com' => 'DC test'))
                ->setTo(array($user->email => $user->username))
              
                ->setBody($plainTextContent);
                 $Mailer->send($Message);
    }

    public function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
