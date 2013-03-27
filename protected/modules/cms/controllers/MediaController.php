<?php

class MediaController extends CmsController
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
			array('allow',
				'users'=>array('*'),
				'actions'=>array('*'),
			),
			array('allow',
				'actions'=>array('admin', 'create', 'update', 'delete'),
				'expression'=>'$user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
				'actions'=>array('admin', 'create', 'update', 'delete'),
			),
		);
	}
	
	public function actionAdmin()
	{
		$this->layout = 'admin';
		
		$model=new CmsMedia('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsMedia']))
			$model->attributes=$_GET['CmsMedia'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionCreate()
	{
		$this->layout = 'admin';
		
		$model=new CmsMedia;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsMedia']))
		{
			$model->attributes=$_POST['CmsMedia'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdate($id)
	{	
		$this->layout = 'admin';
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsMedia']))
		{
			$model->attributes=$_POST['CmsMedia'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionUpload()
	{
		echo Yii::app()->cms->uploadMedia();
	}
	
	public function actionInsertMedia() {
		$this->layout = false;
		
		if($media = CmsMedia::model()->findByPk($_POST['media_id'])) {
			//Do insert into join table manually
			$command = Yii::app()->db->createCommand();
			$command->insert('cms_content_media', array(
			    'content_id'=>$_GET['content_id'],
			    'media_id'=>$media->id,
			    'type'=>$_GET['type'],
			));
			
			$this->render('newMedia',array(
				'media'=>$media
			));
		}
	}
	
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return CmsNode the model
     * @throws CHttpException if the node does not exist.
     */
    public function loadModel($id)
    {
            $model = CmsMedia::model()->findByPk($id);

            if ($model === null)
                    throw new CHttpException(404, Yii::t('CmsModule.core', 'The requested page does not exist.'));

            return $model;
    }
	
}