<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CmsUserIdentity extends CUserIdentity
{
	private $_id;
	
	/**
	 * @var User $user user model that we will get by email
	 */
	public $user;

	public function __construct($username,$password=null)
	{
		// sets username and password values
		parent::__construct($username,$password);

		$this->user = CmsUser::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		//try with email
		if($this->user===null)
			$this->user = CmsUser::model()->find('LOWER(email)=?',array(strtolower($this->username)));

		if($password === null)
		{
			/**
			 * you can set here states for user logged in with oauth if you need
			 * you can also use hoauthAfterLogin()
			 * @link https://github.com/SleepWalker/hoauth/wiki/Callbacks
			 */
			$this->errorCode=self::ERROR_NONE;
		}
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{ 
		if($this->user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$this->user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			// successful login
			$this->_id=$this->user->id;
			$this->username=$this->user->username;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->user->id;
	}
}