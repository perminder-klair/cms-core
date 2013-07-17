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
class UserProfileForm extends CFormModel {

    //put your code here

    public $first_name;
    public $last_name;
    public $register_email;
    public $telephone;
    public $address_line_2;
    public $address;
    public $city;
    public $postcode;

    public function rules() {
        return array(
            array('first_name,address_line_2,last_name,register_email', 'required'),
            array('first_name,address_line_2,last_name,register_email', 'safe'),
            array('telephone,address,city,postcode', 'required'),
            array('register_email', 'email'),
            array('register_email', 'uniqueEmail'),
        );
    }

    /**
     * ensure email doesnt belong to anyone else
     * @return boolean
     */
    public function uniqueEmail() {
        if (CmsUser::model()->exists("id != " . userId() . " AND email='{$this->register_email}'")) {
            $this->addError('register_email', 'Email already exist');
        }
    }

    public function attributeLabels() {
        return array(
            'password_confirm' => 'Password Confirmation',
            'email_confirm' => 'Email Confirmation',
            'register_email' => 'Email'
        );
    }

    public function updateProfile() {
        $user = CmsUser::model()->findByPk(userId());
        if (!$user instanceof CmsUser) {
            return false;
        }

        $user->setAttributes(
                array(
                    'firstname' => $this->first_name,
                    'lastname' => $this->last_name,
                    'email' => $this->register_email,
        )); // $this->attributes;
        if (!$user->save()) {
            $this->addErrors($user->getErrors());
            return false;
        }

        $profile = CmsUserProfile::model()->findByPk(userId());
        $profile->setAttributes(
                array(
                    'telephone' => $this->telephone,
                    'city' => $this->city,
                    'postcode' => $this->postcode,
                    'address' => $this->address,
                    'address_line_2' => $this->address_line_2,
        ));
        
        if (!$profile->save(false)) {
            $this->addErrors($profile->getErrors());
            return false;
        }

        return true;
    }

}

?>
