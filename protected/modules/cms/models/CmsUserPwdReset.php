<?php

/**
 * This is the model class for table "cms_user_pwd_reset".
 *
 * The followings are the available columns in table 'cms_user_pwd_reset':
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $key
 * @property string $created_date
 */
class CmsUserPwdReset extends SiteActiveRecord
{
    public $password_repeat,$password_copy,$link;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CmsUserPwdReset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_user_pwd_reset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, password_repeat', 'required'),
			array('email', 'length', 'max'=>70),
            array('email','email'),
			array('password', 'length', 'min'=>'6','max'=>90),
			array('password', 'compare'),
			array('key', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, key, created_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'New Password',
			'password_repeat' => 'Confirm Password',
			'key' => 'Key',
			'created_date' => 'Created Date',
		);
	}
        
    public function savePassword()
    {
        $user = CmsUser::model()->find(array(
            'condition'=>'email=:email',
            'params'=> array(
                ':email'=>$this->email
            )
        ));

        if(!$user instanceof CmsUser){
            $this->addError('email', 'Email not found');
            return false;
        }

        $this->password_copy = $this->password;

        $this->key = md5($user->id.rand(20, 100));
        $this->password=$user->hashPassword($this->password);

        $this->link = Yii::app()->controller->createAbsoluteUrl('/account/validatePassword',array('key'=>$this->key,'email'=>$this->email));

        $this->deleteAll("email='{$this->email}'");//delete all records of that email

        if($this->save(false) && $this->sendPasswordEmail()){
            return true;
        }
        $this->password = $this->password_copy;
        return false;
    }

    protected function sendPasswordEmail()
    {
        $subject = '=?UTF-8?B?' . base64_encode('Password reset validation link at '.gl('site_name')) . '?=';

        $emailData = array(
            'view'=>'passwordReset',
            'mailData'=>array(
                'link'=>$this->link,
            ),
            'fromEmail'=>gl('admin_email'),
            'fromName'=>gl('site_name'),
            'subject'=>$subject,
            'toEmail'=>array($this->email),
        );

        if(Mail::sendEmail($emailData))
            return true;
    }
}
