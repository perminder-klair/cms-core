<?php

class DemoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
	public $defaultAction = 'index';

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
				'actions'=>array('admin', 'create', 'update', 'delete'),
				'expression'=>'$user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
				'actions'=>array('admin', 'create', 'update', 'delete'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Demo;
		if($model->save())
			$this->redirect(array('update','id'=>$model->id));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{	
		$layout = 'application.modules.cms.views.layouts.admin';
		$this->layout = $layout;
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Demo']))
		{
			$model->attributes=$_POST['Demo'];
			
			//Update Categories
			$model->setRelationRecords('categories', $_POST['Demo']['activeCategories'], array('type' => 'demo'));
			
			if($model->save()) {
				Yii::app()->user->setFlash('success','Demo has been updated!');
				$this->redirect(array('update', 'id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Demo');
		//$dataProvider = Demo::model()->live()->findAll();
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$layout = 'application.modules.cms.views.layouts.admin';
		$this->layout = $layout;
		
		$model=new Demo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Demo']))
			$model->attributes=$_GET['Demo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Show And Hide row
	 */
	public function actionToggleActive()
	{
		//1 = Active, 0 = Hidden
		if($model=$this->loadModel($_GET['id']))
		{ 
			if($model->active==0) { 
				$model->active=1;
				$result = 'Hide';
			} elseif($model->active==1) {
				$model->active=0;
				$result = 'Show';
			}
				
			if($model->save()) { 
				echo $result;
			}
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Demo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Demo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Demo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		/*if(isset($_POST['ajax']) && $_POST['ajax']==='demo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}*/
		
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			echo CActiveForm::validate( array( $model)); 
			Yii::app()->end(); 
		}
	}
}
