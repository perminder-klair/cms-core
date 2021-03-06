<?php

/**
 * This is the model class for table "cms_categories".
 *
 * The followings are the available columns in table 'cms_categories':
 * @property string $id
 * @property string $title
 * @property string $url
 * @property integer $parent
 */
class CmsCategories extends SiteActiveRecord
{
	
	public $category_id = 'id';
	
	const TYPE_BLOG=1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CmsCategories the static model class
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
		return 'cms_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, category_type', 'required'),
			array('parent, category_type', 'numerical', 'integerOnly'=>true),
			array('title, url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url, parent, category_type', 'safe', 'on'=>'search'),
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
			'url' => 'Url',
			'parent' => 'Parent',
			'category_type' => 'Type',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->url = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->title));
			
			return true;
		}
		else
			return false;
	}
	
	public function adminActions()
	{
		$result = l('Edit',array('/cms/categories/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/categories/delete",array('id'=>$this->id))));

    	return $result;
	}
	
	/**
	 * get all Categories for a specific type
	 * use as: CmsCategories::getAllCategories('TYPE_HERE');
	 */
	public static function getAllCategories($type)
	{
		$criteria=new CDbCriteria(
			array("condition"=>"category_type = {$type}")
		);
		$allCategories = CmsCategories::model()->findAll($criteria);
		
		$categories = array();
		foreach ($allCategories as $category) {
		    $categories[$category->id] = $category->title;
		}
		
		return $categories;
	}
	
	/**
     * @param $type
     * @return categories
     */
    public static function listAllCategories($type)
    {
        $criteria=new CDbCriteria(
            array("condition"=>"category_type = {$type}")
        );
        return CmsCategories::model()->findAll($criteria);
    }
}