<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CmsRegisterForm
 *
 * @author admin
 */
class PasswordUpdateForm extends CFormModel {

    //put your code here

    public $oldpassword;
    public $password_confirm;
    public $password;
    public $new_password_repeat;
    public $user = null;



    public function rules() {
        return array(
            array('oldpassword,password_confirm,password', 'required'),
            array('oldpassword,password_confirm,password', 'safe'),
            array('password_confirm', 'compare', 'compareAttribute'=>'password'),
            array('oldpassword', 'validatePassword'),
            array('password', 'length', 'max' => 20, 'min' => 6),


        );
    }

    /**
     * ensure old password is correct
     */
    public function validatePassword() {
        $this->user = CmsUser::model()->findByPk(userId());
        if(!($this->user instanceof CmsUser && $this->user->validatePassword($this->oldpassword))){
            $this->addError('oldpassword', 'Old password not right');
            return false;
        }
        return true;
    }

    public function attributeLabels() {
        return array(
            'password_confirm' => 'New Password Confirmation',
            'password' => 'New Password',
            'oldpassword' => 'Old Password'
        );
    }

    public function update() {
        $this->user->scenario = 'changePassword';
        $this->user->setAttributes(
                array(
                    'new_password' => $this->password,
                    'new_password_repeat'=>$this->password,
                    'password' => $this->password
        ));
        if (!$this->user->save(false)) {
            $this->addErrors($this->user->getErrors());
            return false;
        }
       
        return true;
    }

}

?>
