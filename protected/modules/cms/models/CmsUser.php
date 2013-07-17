<?php

class CmsUser extends CmsActiveRecord
{
	/**
	 * The followings are the available columns in table 'cms_user':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $profile
	 */
	public $new_password;
	public $new_password_repeat;
	public $defaultRole='user';
	
	const STATUS_INACTIVE=1;
	const STATUS_ACTIVE=2;
	const STATUS_BANNED=3;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return 'cms_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email', 'required'),
			array('firstname, lastname', 'length', 'max'=>50),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => "Incorrect username (length between 3 and 20 characters)."),
			array('email', 'email'),
			array('username', 'unique', 'message' => "This user's name already exists."),
			array('email', 'unique', 'message' => "This user's email address already exists."),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => "Incorrect symbols (A-z0-9)."),
			array('status', 'in', 'range'=>array(1,2,3)),
            //array('created', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            //array('modified', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('new_password, new_password_repeat', 'length', 'max'=>50),
		    array('new_password', 'compare', 'compareAttribute'=>'new_password_repeat', 'on'=>'changePassword'),
		    //array('new_password', 'required', 'on'=>'create'),
		    array('username, email, status, password, new_password, new_password_repeat, userRole', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'profile'=>array(self::HAS_ONE, 'CmsUserProfile', 'user_id'),
			'posts' => array(self::HAS_MANY, 'CmsBlog', 'author_id'),
			'media'=>array(self::MANY_MANY, 'CmsMedia', 'cms_content_media(content_id, media_id)', 'condition' => 'type = "user"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'status' => 'Status',
			'created' => 'Created Date',
			'modified' => 'Modified Date',
		);
	}

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email);
		
		//use roles property
		//$criteria->compare('role.itemname', $this->role, true, 'OR');
		//$criteria->with = array('role');

		return new CActiveDataProvider('CmsUser', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'created DESC',
			),
		));
	}
	
	public function beforeSave()
	{
	    if(($this->getScenario() === 'create') || ($this->getScenario() === 'changePassword'))
	    {
	        //hash new password
	        $this->password = $this->hashPassword($this->new_password); 
	    }
	    
	    return parent::beforeSave();
	}
	
	public function afterSave() {
	    parent::afterSave();
	    
	    if ($this->isNewRecord) {
	        //create profile row
			/*$profile = new CmsUserProfile;
			$profile->user_id = $this->id;
			$profile->save();*/
			
			//update user role
		    $this->setUserRole($this->defaultRole);
	    }
	}
	
    public function afterDelete()
    {
    	parent::afterDelete();
    	
    	//deletes profile row
    	$this->profile->delete();
    	
    	//This is invoked after the record is deleted.
    	$this->revokeRole();
    }
	
	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return crypt($password,$this->password)===$this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return crypt($password, $this->generateSalt());
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 *
	 * The {@link http://php.net/manual/en/function.crypt.php PHP `crypt()` built-in function}
	 * requires, for the Blowfish hash algorithm, a salt string in a specific format:
	 *  - "$2a$"
	 *  - a two digit cost parameter
	 *  - "$"
	 *  - 22 characters from the alphabet "./0-9A-Za-z".
	 *
	 * @param int cost parameter for Blowfish hash algorithm
	 * @return string the salt
	 */
	protected function generateSalt($cost=10)
	{
		if(!is_numeric($cost)||$cost<4||$cost>31){
			throw new CException(Yii::t('Cost parameter must be between 4 and 31.'));
		}
		// Get some pseudo-random data from mt_rand().
		$rand='';
		for($i=0;$i<8;++$i)
			$rand.=pack('S',mt_rand(0,0xffff));
		// Add the microtime for a little more entropy.
		$rand.=microtime();
		// Mix the bits cryptographically.
		$rand=sha1($rand,true);
		// Form the prefix that specifies hash algorithm type and cost parameter.
		$salt='$2a$'.str_pad((int)$cost,2,'0',STR_PAD_RIGHT).'$';
		// Append the random salt string in the required base64 format.
		$salt.=strtr(substr(base64_encode($rand),0,22),array('+'=>'.'));
		return $salt;
	}
	
	/*
	 * @returns Name of the author
	 */
	public function getName()
	{
		if(empty($this->firstname)) {
			$name = $this->username;
		} else {
			$name = $this->firstname;
			if(!empty($this->lastname))
			$name .= ' '.$this->lastname;
		}
				
		return $name;
	}
	
	public function adminStatus()
	{
		if($this->status==self::STATUS_ACTIVE)
			$tag = 'label-success';
		elseif($this->status==self::STATUS_BANNED)
			$tag = 'label-important';
		else
			$tag = '';
			
		return '<span class="label '.$tag.'">'.CmsLookup::item("UserStatus", $this->status).'</span>';
	}
	
	public function adminActions()
    {
    	$result = l('Edit',array('/cms/user/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/user/delete",array('id'=>$this->id))));
    	
    	return $result;
    }
    
    /*
     * Role management
     */
	public function getUserRole($id=null) 
	{
		if($id)
			$this->id=$id;
			
        $role = Yii::app()->db->createCommand()
                ->select('itemname')
                ->from('AuthAssignment')
                ->where('userid=:id', array(':id'=>$this->id))
                ->queryScalar();

        return $role;
	}
	
	public function setUserRole($role=null)
	{
		if($role!==$this->getUserRole($this->id)) {
			$this->revokeRole(); //to delete old role
			$auth=Yii::app()->authManager;
			$auth->assign($role, $this->id); //create new role
		}
	}
	
	protected function revokeRole()
	{
		$auth=Yii::app()->authManager;
		$auth->revoke($this->getUserRole($this->id), $this->id);
	}

    public function getRolesAsListData()
	{
		$roles = Yii::app()->authManager->getRoles();
		if(Yii::app()->user->getDetails()->userRole!='super') unset($roles['super']);
		return CHtml::listData($roles,'name','description');    
	}
	
	public function getOperationsAsListData()
	{
		$roles = Yii::app()->authManager->getOperations();
		return CHtml::listData($roles,'name','description');    
	}
	
	public function getAllOperations()
	{
		$operations = Yii::app()->authManager->getOperations();
		return CHtml::listData($operations,'name','description'); 
	}
	
    /**
     * Returns media in array
     * $rowCount=$command->execute();   // execute the non-query SQL
     * $dataReader=$command->query();   // execute a query SQL
     * $rows=$command->queryAll();      // query and return all rows of result
     * $row=$command->queryRow();       // query and return the first row of result
     * $column=$command->queryColumn(); // query and return the first column of result
     * $value=$command->queryScalar();  // query and return the first field in the first 
     * Usage:
	 * if($media = $data->mediaType(CmsMedia::TYPE_OTHER)) {
	 * 	$image=CmsMedia::getMedia($media['id']);
	 *	dump($image->render());
	 * }
     */
    public function mediaType($type, $count=null)
    {
    	$sql = "SELECT md.* FROM cms_content_media AS cm, cms_media as md";
    	$sql .= " WHERE cm.media_id=md.id";
    	$sql .= " AND cm.type='user'";
    	$sql .= " AND cm.content_id=".$this->id;
    	$sql .= " AND md.media_type=".$type;
    	
	    $result = Yii::app()->db->createCommand($sql);
	    
	    if($count=='all')
	    	return $result->queryAll();
	    else {
	    	$row = $result->queryRow();
	    	return CmsMedia::model()->findByPk($row['id']);
	    }
    }
    
    public function authorImage()
    {
	    if($media = $this->mediaType(CmsMedia::TYPE_FEATURED)) {
			$image=CmsMedia::getMedia($media['id']);
			return baseUrl().$image->render(array('height' => '50', 'width' => '50', 'smart_resize' => true));
		} else {
			return false;
		}
    }
    
    /* Returns User model by its email
	 * 
	 * @param string $email 
	 * @access public
	 * @return User
	 */
	public function findByEmail($email)
	{
		return self::model()->findByAttributes(array('email' => $email));
	}
	
}