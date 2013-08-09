<?php

class CmsBlocks extends CmsActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className the class name
	 * @return CmsBlocks the static model class
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
    	return 'cms_blocks';
    }

    /**
     * @return array validation rules for model attributes
     */
    public function rules()
    {
        return array(
        	array('name, body', 'required'),
            array('id, parentId, published, deleted', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            array('modified, body', 'safe'),
            array('id, created, modified, parentId, name, deleted, body', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules
     */
    public function relations()
    {
        return array(
        	'parent'=>array(self::BELONGS_TO, 'CmsPage', 'parentId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '#',
            'created' => Yii::t('CmsModule.core', 'Created'),
            'modified' => Yii::t('CmsModule.core', 'Updated'),
            'name' => Yii::t('CmsModule.core', 'Name'),
            'parentId' => Yii::t('CmsModule.core', 'Parent'),
            'published' => Yii::t('CmsModule.core', 'Published'),
            'deleted' => Yii::t('CmsModule.core', 'Deleted'),
            'body' => Yii::t('CmsModule.core', 'Body'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('body',$this->body,true);
        $criteria->compare('parentId',$this->updated);

        return new CActiveDataProvider($this, array(
        	'criteria'=>$criteria,
        ));
    }
    
    public function beforeSave() {
	    $this->name = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->name));
	 
	    return parent::beforeSave();
	}
	
	public function scopes()
    {
        return array(
            'published'=>array(
            	'condition'=>'published = 1 AND deleted = 0',
            ),
        );
    }

    /**
     * Returns the body for this node.
     * @return string the body
     */
    public function getBody()
    {
    	if (!empty($this->body))
            $body = $this->body;
        else
            $body = '';

        return $body;
    }

    /**
     * Renders this as a widget.
     * @return string the rendered widget
     */
    public function renderWidget()
    {
    	return Yii::app()->cms->renderer->renderWidget($this);
    }
        
    public function adminActions()
    {
    	$result = l('Edit',array('/cms/blocks/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/blocks/delete",array('id'=>$this->id))));
    	
    	return $result;
    }
}