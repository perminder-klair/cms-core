<?php

class RegisterForm extends CFormModel{

    public $username;
    public $new_password;
    public $new_password_repeat;
    public $email;
    public $firstname;
    public $lastname;
    public $address;
    public $postcode;
    
    public function rules()
    {
        return array(
            array('username, new_password, new_password_repeat','required'),
            array('firstname, lastname', 'length', 'max'=>50),
            array('username', 'length', 'max'=>20, 'min' => 3,'message' => "Incorrect username (length between 3 and 20 characters)."),
            array('email','email'),
            array('username', 'uniqueUsername'),
            array('email', 'uniqueEmail'),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => "Incorrect symbols (A-z0-9)."),
            array('new_password, new_password_repeat', 'length', 'max'=>50),
            array('new_password', 'compare', 'compareAttribute'=>'new_password_repeat'),

            array('username, email, firstname, lastname, address, postcode, new_password, new_password_repeat','safe'),
        );
    }
    
    public function uniqueEmail()
    {
        if(CmsUser::model()->exists("email='{$this->email}'")){
            $this->addError('email','This user email address already exists.');
            return false;
        }
        return true;
    }

    public function uniqueUsername()
    {
        if(CmsUser::model()->exists("username='{$this->username}'")){
            $this->addError('usernme','This users name already exists.');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return array(
            'username' => 'Username',
            'new_password' => 'Password',
            'new_password_repeat' => 'Password Repeat',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
        );
    }

    public function register()
    {
        if($_POST['RegisterForm']) {
            $user = new CmsUser('create');
            $user->attributes=$_POST['RegisterForm'];
            $user->status=CmsUser::STATUS_ACTIVE;
            $user->activkey=genRandomString();
            if(!$user->save()) {
                $this->addErrors($user->getErrors());
                return false;
            }

            $userProfile = new CmsUserProfile;
            $userProfile->user_id=$user->id; //insert user profile
            $userProfile->attributes=$_POST['RegisterForm'];
            if(!$userProfile->save())
                return false;

            //send register success email
            $this->sendRegisterSuccessEmail($user);
        }
    
        return true;
    }

    protected function sendRegisterSuccessEmail($user)
    {
        $subject = '=?UTF-8?B?' . base64_encode('Registration success at '.gl('site_name')) . '?=';

        $emailData = array(
            'view'=>'registerSuccess',
            'mailData'=>array(
                'userEmail'=>$user->email,
                'userName'=>$user->getName(),
            ),
            'fromEmail'=>gl('admin_email'),
            'fromName'=>gl('site_name'),
            'subject'=>$subject,
            'toEmail'=>array($user->email),
        );

        if(Mail::sendEmail($emailData))
            return true;
    }
    
}
