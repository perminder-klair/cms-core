<?php

class UserController extends CmsController
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			array('cms.filters.AuthFilter'),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = 'admin';
		
		$model=new CmsUser('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['CmsUser']))
			$model->attributes=$_GET['CmsUser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{ 
		$model=new CmsUser();
		$model->username='new_user';
		$model->email='user@user.com';
		if($model->save())
			$this->redirect(array('update', 'id'=>$model->id));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout = 'admin';
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsUser']))
		{ //dump($_POST['CmsUser']); die();
			$model->attributes=$_POST['CmsUser'];
			
			// if a new password has been entered
		    if ($model->new_password !== '') 
		    	$model->setScenario('changePassword'); // set scenario 'changePassword' in order for the compare validator to be called
		    	
		    //update user role
		    $model->setUserRole($_POST['CmsUser']['userRole']);

			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect('/cms/user/admin');
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Film the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CmsUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Film $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='film-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
}