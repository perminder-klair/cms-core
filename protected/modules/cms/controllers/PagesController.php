<?php

class PagesController extends CmsController
{

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
		
		$model=new CmsPage('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['CmsPage']))
			$model->attributes=$_GET['CmsPage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
     * Displays the page to create a new model.
     */
    public function actionCreate()
    {
    	$model = new CmsPage();
    	$model->name = 'new-page';
    	$model->heading = 'New Page';
    	$model->body = 'page body...';
    	$model->status = '1';
    	$model->type = '1';
        if ($model->save())
        	$this->redirect(array('update', 'id'=>$model->id));
    }
    
	/**
     * Displays a particular page.
     * @param $id the id of the model to display
     */
    public function actionView($id)
    {
	    $model = $this->loadModel($id);

        $pageView = $model->layout;
        $this->render('//cms_pages/'.$pageView, array(
            'model'=>$model,
            'content'=>$model->render(),
            'children'=>$model->children(array( 'scopes'=>array( 'published' ) )),
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

		if(isset($_POST['CmsPage']))
		{
			$model->attributes=$_POST['CmsPage'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Page Updated!");
				$this->redirect(array('update','id'=>$model->id));
			}
		}
		
		Yii::app()->cms->sisyphus();

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
        $model = CmsPage::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, Yii::t('CmsModule.core', 'The requested page does not exist.'));

        return $model;
    }

}