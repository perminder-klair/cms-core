<?php

/**
 * This is the model class for table "demo".
 *
 * The followings are the available columns in table 'demo':
 * @property string $id
 * @property string $title
 * @property string $created
 * @property string $updated
 * @property integer $listing_order
 * @property integer $active
 * @property integer $deleted
 */
class Demo extends SiteActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Demo the static model class
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
		return 'demo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title', 'required'),
			array('listing_order, active, deleted', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, created, updated, listing_order, active, deleted', 'safe', 'on'=>'search'),
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
			'media'=>array(self::MANY_MANY, 'CmsMedia', 'cms_content_media(content_id, media_id)', 'condition' => 'type = "demo"'),
			'categories'=>array(self::MANY_MANY, 'CmsCategories', 'cms_content_categories(content_id, category_id)', 'condition' => 'type = "demo"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'created' => 'Created',
			'updated' => 'Updated',
			'listing_order' => 'Listing Order',
			'active' => 'Active',
			'deleted' => 'Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order='id DESC';
		$criteria->condition='deleted = 0';

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('listing_order',$this->listing_order);
		$criteria->compare('active',$this->active);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Model class can have a default scope that would be applied for all queries (including relational ones) about the model. 
	 */
	public function scopes()
    {
        return array(
        	'live'=>array(
            	'order'=>'listing_order ASC',
            	'condition'=>'deleted=0 AND active=1',
            ),
        );
    }
    
    /**
     * This method is invoked after each record is instantiated by a find method.
     */
    public function afterFind()
    {
    
    	$this->created = date('m/d/Y',strtotime($this->created));
        $this->updated = date('m/d/Y',strtotime($this->updated));
    	
	    return parent::afterFind();
    }
	
	/**
	 * This is invoked before the record is saved.
	 */
	public function beforeSave()
    {
	    if (parent::beforeSave())
	    {
            if ($this->isNewRecord) {
            	//Update Listing order
            	$this->listing_order=$this->findLastListingNumber();
            } else {

            }
            
            $this->created = date('Y-m-d',strtotime($this->created));
            $this->updated = date('Y-m-d',strtotime($this->updated));
            
            return true;
		}
		else
			return false;
    }
    
	/**
	 * This is invoked after the record is deleted.
	 */
	public function afterDelete()
	{	
		parent::afterDelete();
		
		//remove all related media
		foreach($this->media as $media) {
			$media->delete();
		}
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
    	$sql .= " AND cm.type='demo'";
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
    
    /**
     * returns Default Image which is selected as featured in CMS
     */
    public function getDefaultImage()
	{
		if($image = $this->mediaType(CmsMedia::TYPE_FEATURED))
			return $image->render();
        elseif($image = $this->media)
            return $image[0]->render();
	}
	
	public function adminActions()
	{
		$currentStatus = $this->active==1?'Hide':'Show';
		$statusButton = $this->active==1?'warning':'success';
		
		$result =  CHtml::ajaxLink(
				        $currentStatus,
				        url('/Demo/toggleActive'),
				        array(
			                'update'=>'.btn-hide-'.$this->id,
			                'method'=>'post',
			                'data'=> array( 'id' => $this->id ),
			                /*'success' => "function( data )
			                {
			                	alert( data );
			                }",*/
				        ),
				        array(
				        	'class'=>"btn btn-mini btn-{$statusButton} btn-hide-".$this->id,
				        )
					);	
		$result .= '&nbsp;&nbsp;'.l('Edit',array('/Demo/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/Demo/delete",array('id'=>$this->id))));

    	return $result;
	}
	
	
	/**
	 * get active categories
	 * make sure to insert raw in cms_lookup table as: type: CategoryType
	 */
	public function getActiveCategories()
	{	
		$categories = Yii::app()->db->createCommand()
		    ->select('*')
		    ->from('cms_content_categories')
		    ->where('content_id=:id', array(':id'=>$this->id))
		    ->andWhere('type=:type', array(':type'=>'demo'))
		    ->queryAll();
		
	    $ids=array();
	    foreach($categories as $c)
	        $ids[]=$c['category_id'];
	        
	    return $ids;
	}
	
	/**
	 * find last listing number
	 */
	private function findLastListingNumber()
    {
        //find listing Order number of last
        $criteria=new CDbCriteria;
        $criteria->order='listing_order DESC';
        
        if($lastID=$this::model()->find($criteria))
        	return $lastID->listing_order+1;
        else
        	return 0;
    }
    
    /**
     * return list of listing Ids array
     */
    public function getListingIdArray()
    {
        for ($i = 1; $i <= $this->findLastListingNumber(); $i++) {
            $array[]=$i;
        }

        return $array;
    }
}