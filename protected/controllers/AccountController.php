<?php

class AccountController extends Controller
{

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('*'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'logout'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('?'),
				'actions'=>array('index', 'logout'),
			),
		);
	}
	
	public function actionIndex()
	{
        if(Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->user->loginUrl);

        $this->render('index', array(
            'user'=>$this->getUser(),
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

        $model=new LoginForm;

        // if it is ajax validation request
        $this->performAjaxValidation($model);

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()) {
                setSuccessMessage('Logged in successfully!');
                $this->redirect(Yii::app()->request->urlReferrer); //Yii::app()->user->returnUrl
            }
        }
        //dump($model->getErrors()); die();
        
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    public function actionRegister()
    {
        if(!Yii::app()->user->isGuest)
            $this->redirect(array('index'));

        if (!defined('CRYPT_BLOWFISH') || !CRYPT_BLOWFISH)
            throw new CHttpException(500, "This application requires that PHP was compiled with Blowfish support for crypt().");

        $model = new RegisterForm;

        // if it is ajax validation request
        $this->performAjaxValidation($model);

        if(isset($_POST['RegisterForm'])) 
        {
            $model->attributes = $_POST['RegisterForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->register()) {
                setSuccessMessage('Registration was successful. You can login.');
                $this->redirect(Yii::app()->user->loginUrl); //Yii::app()->user->urlReferrer
            }
        }
        //dump($model->getErrors()); die();
        
        // display the register form
        $this->render('register', array('model' => $model));
    }
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
        setSuccessMessage('You are successfully logged out!');
		Yii::app()->request->redirect(Yii::app()->user->returnUrl);
	}

    public function actionPasswordReset()
    {
        $model = new CmsUserPwdReset;
        
        if(isset($_POST['CmsUserPwdReset'])){
            $model->attributes = $_POST['CmsUserPwdReset'];
            if($model->validate() && $model->savePassword()){
                setSuccessMessage('Click on the validation link sent to your email to activate new password.');
                $this->refresh();
            }
        }
        //dump($model->getErrors()); die();

        $this->render('passwordReset',array('model'=>$model));
    }

    /**
     * Validates validation link from email
     * @param string $key
     * @param string $email
     */
    public function actionValidatePassword($key, $email)
    {
        $model = CmsUserPwdReset::model()->findByAttributes(array(
                'key'=>$key,
                'email'=>$email
            )
        );

        if($model instanceof CmsUserPwdReset)
        {
            $user = CmsUser::model()->findByAttributes(array(
                'email'=>$email
            ));

            if($user instanceof CmsUser){

                $user->password = $model->password;
                if($user->save())
                {
                    $model->deleteAll("email='{$model->email}'");
                    setSuccessMessage('Your password has been successfully changed.');
                    $this->redirect(Yii::app()->user->loginUrl);
                }

            }
        } else {

            setErrorMessage('Link is not valid');
            $this->redirect(array('passwordReset'));

        }
    }
	
	/**
	 * Performs the AJAX validation.
	 * @param Film $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * @return user
     */
    protected function getUser()
	{
		return CmsUser::model()->findByPk(Yii::app()->user->id);
	}
	
}