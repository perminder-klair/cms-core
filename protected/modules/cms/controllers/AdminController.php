<?php

class AdminController extends CmsController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('login'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
				'actions'=>array('logout'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('index', 'settings'),
				'expression'=>'$user->isAdmin()'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
				//'actions'=>array('index', 'settings'),
			),
			/*array('deny',  // deny all users
				'users'=>array('@'),
				//'actions'=>array('admin'),
			),*/
		);
	}
	
	public function actionIndex()
	{ //dump(isAdmin()); die();
		$this->layout = 'admin';
		
		$criteria=new CDbCriteria(array(
			//'condition' => 'type = "blog"',
			'limit'=>'10'
		));
		$blogs = CmsBlog::model()->published()->recent()->findAll();
		
		$comments = CmsComment::model()->recent()->findAll($criteria);
		
		$this->render('index', array(
			'blogs'=>$blogs,
			'comments'=>$comments,
		));
	}
	
	public function actionSettings()
	{ 
		$this->layout = 'admin';
		
		$model = new CmsSettings();
		$settings = $model->model()->findAll();
		
		if(isset($_POST['CmsSettings']))
		{
			foreach($_POST['CmsSettings'] as $key=>$val) {
				$setting = CmsSettings::model()->findByAttributes(array('define'=>$key));
				$setting->value = $val;
				$setting->save();
			}
			$this->redirect(array('settings'));
		}
		
		$this->render('settings', array(
			'model'=>$model,
			'settings'=>$settings
		));
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		//Check if visitor is not guest then redirect to index page
		if(!Yii::app()->user->isGuest)
			$this->redirect(array('index'));
	
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");
			
		$this->layout = 'full_admin';
		
		$model=new CmsLogin;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['CmsLogin']))
		{
			$model->attributes=$_POST['CmsLogin'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$this->redirect(array("/cms/admin"));
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionUser()
	{
		$this->layout = 'admin';
		
		$this->render('user');
	}
}