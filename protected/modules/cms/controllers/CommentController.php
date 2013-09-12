<?php

class CommentController extends CmsController
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			array('cms.filters.AuthFilter'),
		);
	}
	
	public function actionAdmin()
	{
		$this->layout = 'admin';
		
		$model = new CmsComment;
		
		$criteria=new CDbCriteria();
		
	    $count=$model->recent()->with('blog')->count($criteria);
	    
	    $pages=new CPagination($count);
	    $pages->pageSize=10; // results per page
	    $pages->applyLimit($criteria);
	    
	    
	    $dataProvider=$model->with('blog')->findAll($criteria);
		
		$this->render('admin', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'pages'=>$pages,
			'count'=>$count,
		));
	}

	public function actionUpdate()
	{
		$this->layout = 'admin';
		
		$model=$this->loadModel();
		
		if(isset($_POST['CmsComment']))
		{
			$model->attributes=$_POST['CmsComment'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Comment Updated!");
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Approves a particular comment.
	 * If approval is successful, the browser will be redirected to the comment index page.
	 */
	public function actionApprove()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$comment=$this->loadModel();
			$comment->approve();
			$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=CmsComment::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
}
