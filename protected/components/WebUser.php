<?php

class WebUser extends CWebUser {

   
    private $_model;
  

    public function username($userId = false) {
        $pk = $userId? : Yii::app()->user->id;
        $user = $this->loadUser($pk);
        return $user->username;
    }

    public function name() {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->name;
    }

    //sdfg
    // Load user model.
    protected function loadUser($id = null) {
        if ($this->_model === null) {
            if ($id !== null)
                $this->_model = User::model()->findByPk($id);
        }
        return $this->_model;
    }

}
