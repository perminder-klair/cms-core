<?php

class CmsBlog extends CmsActiveRecord
{
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;
	public $restore;
	public $selectedCategories;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_blog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=>array(1,2,3)),
			array('title, slug', 'length', 'max'=>70),
			array('metaDescription', 'length', 'max'=>160),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
			array('media, metaDescription, blog_type, parentId', 'safe'), 
			array('title, status, blog_type, date_start', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'media'=>array(self::MANY_MANY, 'CmsMedia', 'cms_content_media(content_id, media_id)', 'condition' => 'type = "blog"'),
			'comments' => array(self::HAS_MANY, 'CmsComment', 'blog_id', 'condition'=>'comments.status="2"', 'order'=>'comments.created DESC'),
			'author' => array(self::BELONGS_TO, 'CmsUser', 'author_id'),
			'commentCount' => array(self::STAT, 'CmsComment', 'blog_id', 'condition'=>'status='.CmsComment::STATUS_APPROVED),
			'revisions' => array(self::HAS_MANY, 'CmsBlog', 'parentId', 'condition'=>'blog_type="revision"', 'order'=>'modified DESC'),
			'categories'=>array(self::MANY_MANY, 'CmsCategories', 'cms_content_categories(content_id, category_id)'),
																		/*, 'condition' => '"blog_type" = "blog"' //NEED TO BE FIXED*/
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'created' => 'Create Time',
			'modified' => 'Update Time',
			'author_id' => 'Author',
			'metaDescription' => 'Short Description',
			'slug' => 'Slug (URL)',
			'blog_type' => 'Type',
			'parentId' => 'Parent Id',
			'date_start' => 'Date Start',
		);
	}
	
	public function scopes()
    {
        return array(
        	'type'=>array(
        		'blog_type'=>'blog',
        	),
            'recent'=>array(
                'order'=>'created DESC',
                'limit'=>10,
            ),
            'published'=>array(
            	'condition'=>'status = '.self::STATUS_PUBLISHED.' AND blog_type = "blog" AND date_start <= NOW()',
            ),
        );
    }

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		if(!empty($this->slug))
			$title = $this->slug;
		else
			$title = $this->title;
		
		return url('/cms/blog/view', array(
			'id'=>$this->id,
			'title'=>$title,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{ 
		$links=array();
		foreach(CmsTag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('/cms/blog/index', 'tag'=>$tag));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=CmsTag::array2string(array_unique(CmsTag::string2array($this->tags)));
	}

	/**
	 * Adds a new comment to this post.
	 * This method will set status and post_id of the comment accordingly.
	 * @param Comment the comment to be added
	 * @return boolean whether the comment is saved successfully
	 */
	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=CmsComment::STATUS_PENDING;
		else
			$comment->status=CmsComment::STATUS_APPROVED;
		$comment->blog_id=$this->id;
		return $comment->save();
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		$this->_oldTags=$this->tags;
		
		$this->modified = date("d/m/Y", strtotime($this->modified));
		
		parent::afterFind();
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->date_start=date('Y-m-d', time());

				if(empty($this->blog_type))
					$this->blog_type = 'blog';
			}
			else
			{
				//Copy the blog as revision
				if($this->restore!==true)
					$this->copyBlog();

				if($this->slug)
					$this->slug = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->slug));
			}
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		CmsTag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
    public function beforeDelete($soft = null)
    {
        //change status to archived
        $this->status=self::STATUS_ARCHIVED;

        parent::beforeDelete($soft);
        //remove all related media
        foreach($this->media as $media) {
            $media->delete();
        }

        CmsComment::model()->deleteAll('blog_id='.$this->id);
        CmsTag::model()->updateFrequency($this->tags, '');
        CmsBlog::model()->deleteAll('parentId='.$this->id);
    }

	/**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status);
		
		$criteria->condition='deleted = 0 AND blog_type = "blog"';

		return new CActiveDataProvider('CmsBlog', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, modified DESC',
			),
		));
	}
	
	public function listAllCategories()
	{
		$criteria=new CDbCriteria(
			array("condition"=>"category_type = ".CmsCategories::TYPE_BLOG)
		);
		$blogCategories = CmsCategories::model()->findAll($criteria);
		
		$categories = array();
		foreach ($blogCategories as $category) {
		    $categories[$category->id] = $category->title;
		}
		
		return $categories;
	}
	
	public function getBlogCategories()
	{	
	
		$categories = Yii::app()->db->createCommand()
		    ->select('*')
		    ->from('cms_content_categories')
		    ->where('content_id=:id', array(':id'=>$this->id))
		    ->andWhere('type=:type', array(':type'=>'blog'))
		    ->queryAll();
		
	    $ids=array();
	    foreach($categories as $c)
	        $ids[]=$c['category_id'];
	        
	    return $ids;
	}
	
	/*
	 * Load list of categories for frontend
	 */
	public static function listActiveCategories($limit)
	{
		$sql = "SELECT category.*, count(cat.category_id) as category_count FROM cms_content_categories as cat, cms_blog as blog, cms_categories as category";
		$sql .= " WHERE cat.content_id = blog.id";
		$sql .= " AND cat.category_id = category.id";
		$sql .= " AND cat.type = 'blog'";
		$sql .= " AND blog.status = 2";
		$sql .= " AND blog.deleted = 0";
		$sql .= " GROUP BY category.id";
		$sql .= " ORDER BY category_count DESC";
		$sql .= " LIMIT ".$limit;
		
		$result = Yii::app()->db->createCommand($sql);
		
		return $result;
	}
	
	/*
	 * Copy the blog as revision
	 */
	private function copyBlog()
	{
	
		$model = CmsBlog::model()->findByPk($this->id); // record that we want to duplicate
		$model->id = null;
		$model->isNewRecord = true;
		$model->parentId = $this->id;
		$model->blog_type = 'revision';
		$model->author_id=Yii::app()->user->id;
		if($model->save()){
			//duplicated
		}
	}
	
	public function revisionTime()
	{
		return date("d/m/Y @ H:i:s", strtotime($this->created));
	}
	
	public function adminActions()
    {
    	$result = l('Edit',array('/cms/blog/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/blog/delete",array('id'=>$this->id))));

    	return $result;
    }
          
    /**
     * Returns media in array
     * $rowCount=$command->execute();   // execute the non-query SQL
     * $dataReader=$command->query();   // execute a query SQL
     * $rows=$command->queryAll();      // query and return all rows of result
     * $row=$command->queryRow();       // query and return the first row of result
     * $column=$command->queryColumn(); // query and return the first column of result
     * $value=$command->queryScalar();  // query and return the first field in the first 
     * Usage:
	 * if($media = $data->mediaType(CmsMedia::TYPE_OTHER)) {
	 * 	$image=CmsMedia::getMedia($media['id']);
	 *	dump($image->render());
	 * }
     */
    public function mediaType($type, $count=null)
    {
    	$sql = "SELECT md.* FROM cms_content_media AS cm, cms_media as md";
    	$sql .= " WHERE cm.media_id=md.id";
    	$sql .= " AND cm.type='blog'";
    	$sql .= " AND cm.content_id=".$this->id;
    	$sql .= " AND md.media_type=".$type;
    	
	    $result = Yii::app()->db->createCommand($sql);
	    
	    if($count=='all')
	    	return $result->queryAll();
	    else {
	    	$row = $result->queryRow();
	    	return CmsMedia::model()->findByPk($row['id']);
	    }
    }
}