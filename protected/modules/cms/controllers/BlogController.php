<?php

class BlogController extends CmsController
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

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$post=$this->loadModel();
		$comment=$this->newComment($post);
		
		$this->pageTitle=$post->title;
		$this->pageDescription=$post->metaDescription; 
		$this->pageKeywords=$post->tags;
		$this->pageAuthor=$post->author->getName();

		$this->render('//blog/view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{ 
		$model = new CmsBlog;
		$model->title = 'New Blog';
		$model->content = 'content for blog...';
		$model->status = '1';
		if($model->save())
			$this->redirect(array('update','id'=>$model->id));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$this->layout = 'admin';
		
		$model=$this->loadModel();
		
		//$this->performAjaxValidation($model);
		
		if(isset($_POST['CmsBlog']))
		{	
			
			$model->attributes=$_POST['CmsBlog'];
			//convert date to system before insert
			$model->date_start=date("Y-m-d H:i:s", strtotime($_POST['CmsBlog']['date_start']));
			
			//Update Categories
			$model->setRelationRecords('categories', $_POST['CmsBlog']['blogCategories'], array('type' => 'blog'));
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Blog Updated!");
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}

		//Yii::app()->cms->sisyphus(); //TODO! NEED TO FIND SOLUTION
		
		//If restored successfully, clear local data created by sisyphus
		if($_GET['restored']=='true') {
			$cs = Yii::app()->getClientScript();
			$cs->registerScript(
			'manualy-sisyphus-release',
			//'self.sisyphus.manuallyReleaseData();',
			'localStorage.clear();',
			CClientScript::POS_END ); 
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
		$this->pageTitle='Blogs';
		$this->pageDescription='All Blogs'; 
		$this->pageKeywords='blogs, news, updates';
		
		$criteria=new CDbCriteria();
		$criteria->order='date_start DESC';
	    $criteria->condition='status = '.CmsBlog::STATUS_PUBLISHED.' AND blog_type = "blog" AND date_start <= NOW()';
		
		//if tag is selected
		if(isset($_GET['tag'])) {
			$criteria->addSearchCondition('tags',$_GET['tag']);
			$this->pageTitle.=" - ".$_GET['tag'];
			$this->pageKeywords=$_GET['tag'];
		}
		
		//if category is selectedd
		if(isset($_GET['category'])) {
			if($category = CmsCategories::model()->findByPk($_GET['category'])) {

			    $criteria->with='categories';
			    $criteria->together=true;
			    $criteria->addCondition('category_id=:category_id');
			    $criteria->params=array(':category_id'=>$category->id);
			    
			    $this->pageTitle.=" - ".$category->title;
				$this->pageKeywords=$category->title;
			}
		}
		
		//show archive
		if(isset($_GET['archive'])) {
			$criteria->addCondition('MONTH(date_start) = '.$_GET['month']);
			$criteria->addCondition('YEAR(date_start) = '.$_GET['year']);
		}
		
	    $count=CmsBlog::model()->count($criteria);
	    
	    $pages=new CPagination($count);
	    $pages->pageSize=10; // results per page
	    $pages->applyLimit($criteria);
	    
	    $dataProvider=CmsBlog::model()->findAll($criteria);
		
		$this->render('//blog/index',array(
			'dataProvider'=>$dataProvider,
			'pages' => $pages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*if(Yii::app()->user->checkAccess('createPost')) {
			dump('yes'); die();
		} else {
			dump('no'); die();
		}*/
		
		$this->layout = 'admin';
		
		$model=new CmsBlog('search');
		
		if(isset($_GET['CmsBlog']))
			$model->attributes=$_GET['CmsBlog'];
			
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionFeed()
	{
		Yii::import('ext.feed.*');
		// RSS 2.0 is the default type
		$feed = new EFeed();
		
		$feed->title= gl('site_name');
		$feed->description = gl('home_meta_description');
		
		//$feed->setImage(gl('site_name'), url("/cms/blog/feed"), 'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');
		
		$feed->addChannelTag('language', 'en-us');
		$feed->addChannelTag('pubDate', date(DATE_RSS, time()));
		$feed->addChannelTag('link', url("/cms/blog/feed") );
		
		// * self reference
		$feed->addChannelTag('atom:link',url("/cms/blog/feed"));
		
		$criteria=new CDbCriteria();
		$dataProvider=CmsBlog::model()->published()->findAll($criteria);
		
		foreach($dataProvider as $blog) {
		
			$item = $feed->createNewItem();
			
			$item->title = $blog->title;
			$item->link = $blog->getUrl();
			$item->date = date('F j, Y',strtotime($blog->created));
			$item->description = $blog->metaDescription;
			// this is just a test!!
			//$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
			
			$item->addTag('author', $blog->author->getName());
			$item->addTag('guid', url('/index'),array('isPermaLink'=>'true'));
		
			$feed->addItem($item);
		}
		
		$feed->generateFeed();
		Yii::app()->end();
	}
	
	public function actionRestore($id)
	{
		$revision = CmsBlog::model()->findByPk($id);
		$parent = CmsBlog::model()->findByPk($revision->parentId);

		$parent->attributes = $revision->attributes;
		$parent->parentId = 0;
		$parent->type = 'blog';
		$parent->restore = true;
		$parent->author_id=Yii::app()->user->id;
		
		if($parent->save()){
			//duplicated
			$this->redirect(array('update','id'=>$parent->id,'restored'=>'true'));
		}
	}
	
	public function actionTags()
	{
		$this->layout = 'admin';
		
		$model=new CmsTag('search');
		
		if(isset($_GET['CmsTag']))
			$model->attributes=$_GET['CmsTag'];
			
		$this->render('tags',array(
			'model'=>$model,
		));
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=CmsTag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
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
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.CmsBlog::STATUS_PUBLISHED.' OR status='.CmsBlog::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=CmsBlog::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($post)
	{
		$comment=new CmsComment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['CmsComment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
		
	/**
	 * Performs the AJAX validation.
	 * @param Film $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		/*if(isset($_POST['ajax']) && $_POST['ajax']==='film-form')
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
