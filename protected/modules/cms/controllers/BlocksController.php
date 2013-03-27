<?php

class BlocksController extends CmsController
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
				'actions'=>array('admin', 'create', 'update', 'delete'),
				'expression'=>'$user->isAdmin()'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = 'admin';
		
		$model=new CmsBlocks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsBlocks']))
			$model->attributes=$_GET['CmsBlocks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
     * Displays the page to create a new model.
     */
    public function actionCreate($id)
    {
    		$this->layout = 'admin';
    		
            $model = new CmsBlocks();

            if (isset($_POST['CmsBlocks']))
            {
                    $model->attributes = $_POST['CmsBlocks'];

                    if ($model->save())
                    {
                            //Yii::app()->user->setFlash(Yii::app()->cms->flashes['success'], Yii::t('CmsModule.core', 'Node created.'));
                            $this->redirect(array('/cms/pages/update', 'id'=>$id));
                    }
            }

            $this->render('create', array(
                    'model'=>$model,
                    'page_id'=>$id,
            ));
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

		if(isset($_POST['CmsBlocks']))
		{
			$model->attributes=$_POST['CmsBlocks'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Block Updated!");
				$this->redirect(Yii::app()->user->returnUrl);
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
		$this->loadModel($id)->delete(true);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
            $model = CmsBlocks::model()->findByPk($id);

            if ($model === null)
                    throw new CHttpException(404, Yii::t('CmsModule.core', 'The requested page does not exist.'));

            return $model;
    }
    
}