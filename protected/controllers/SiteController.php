<?php

class SiteController extends Controller
{

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{		
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
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
				$this->redirect('/index');	//Yii::app()->user->returnUrl
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	
	/*public function actionTest()
	{
		$auth=Yii::app()->authManager;
	    
	    // remove all operations, roles, child relationships, and assignments
	    $auth->clearAll();
	
	    // create operations for User
	    $auth->createOperation("readUser","Read existing User");
	    $auth->createOperation("adminUser","Manage Users");
	    $auth->createOperation("createUser","Create a new User");
	    $auth->createOperation("updateUser","Update a User");
	    $auth->createOperation("deleteUser","Delete a User");
	    $auth->createOperation("updateOwnUser","Update own User"); // needs bizRule
	    // create operations for Author
	    $auth->createOperation("readAuthor","Read existing Author");
	    $auth->createOperation("adminAuthor","Manage Authors");
	    $auth->createOperation("createAuthor","Create a new Author");
	    $auth->createOperation("updateAuthor","Update an Author");
	    $auth->createOperation("deleteAuthor","Delete an Author");
	    // create operations for Quote
	    $auth->createOperation("readQuote","Read existing Quote");
	    $auth->createOperation("adminQuote","Manage Quotes");
	    $auth->createOperation("createQuote","Create a new Quote");
	    $auth->createOperation("updateQuote","Update a Quote");
	    $auth->createOperation("deleteQuote","Delete a Quote");
	    // create operations for Drink
	    $auth->createOperation("readDrink","Read existing Drink");
	    $auth->createOperation("adminDrink","Manage Drinks");
	    $auth->createOperation("createDrink","Create a new Drink");
	    $auth->createOperation("updateDrink","Update a Drink");
	    $auth->createOperation("deleteDrink","Delete a Drink");
	    // create operations for Product
	    $auth->createOperation("readProduct","Read existing Product");
	    $auth->createOperation("adminProduct","Manage Products");
	    $auth->createOperation("createProduct","Create a new Product");
	    $auth->createOperation("updateProduct","Update an Product");
	    $auth->createOperation("deleteProduct","Delete an Product");
	    // create operations for Ingredient
	    $auth->createOperation("readIngredient","Read existing Ingredient");
	    $auth->createOperation("adminIngredient","Manage Ingredients");
	    $auth->createOperation("createIngredient","Create a new Ingredient");
	    $auth->createOperation("updateIngredient","Update an Ingredient");
	    $auth->createOperation("deleteIngredient","Delete an Ingredient");
	    // create operations for Unit
	    $auth->createOperation("readUnit","Read existing Unit");
	    $auth->createOperation("adminUnit","Manage Units");
	    $auth->createOperation("createUnit","Create a new Unit");
	    $auth->createOperation("updateUnit","Update an Unit");
	    $auth->createOperation("deleteUnit","Delete an Unit");
	    
	    // create guest role and add read operations
	    $bizRule="return Yii::app()->user->isGuest;";
	    $role=$auth->createRole("guest", "guest user", $bizRule);
	    $role->addChild("readAuthor");
	    $role->addChild("readQuote");
	    $role->addChild("readDrink");
	    $role->addChild("readProduct");
	    $role->addChild("readIngredient");
	    $role->addChild("readUnit");
	    
	    // create authenticated role and add guest role and update own user permission
	    $bizRule="return !Yii::app()->user->isGuest;";
	    $role=$auth->createRole("authenticated", "authenticated user", $bizRule);
	    $role->addChild("guest");
	    $role->addChild("UpdateOwnUser");
	
	    // create owner role and assign all create, update, and delete permissions
	    $role=$auth->createRole("owner", "owner user");
	    //$role->addChild("authenticated"); // should not be necessary, owner will be authenticated
	    $role->addChild("readUser");
	    $role->addChild("adminUser");
	    $role->addChild("createUser");
	    $role->addChild("updateUser");
	    $role->addChild("deleteUser");
	    $role->addChild("adminQuote");
	    $role->addChild("createQuote");
	    $role->addChild("updateQuote");
	    $role->addChild("deleteQuote");
	    $role->addChild("adminAuthor");
	    $role->addChild("createAuthor");
	    $role->addChild("updateAuthor");
	    $role->addChild("deleteAuthor");
	    $role->addChild("adminDrink");
	    $role->addChild("createDrink");
	    $role->addChild("updateDrink");
	    $role->addChild("deleteDrink");
	    $role->addChild("adminProduct");
	    $role->addChild("createProduct");
	    $role->addChild("updateProduct");
	    $role->addChild("deleteProduct");
	    $role->addChild("adminIngredient");
	    $role->addChild("createIngredient");
	    $role->addChild("updateIngredient");
	    $role->addChild("deleteIngredient");
	    $role->addChild("adminUnit");
	    $role->addChild("createUnit");
	    $role->addChild("updateUnit");
	    $role->addChild("deleteUnit");
	
	    // assign owner role
	    $auth->assign("owner","1");
	
	    // success message
	    echo "Authorization hierarchy successfully generated.";

	}*/

}