<?php

class CmsMedia extends CmsActiveRecord
{
	const STATUS_NOT_PUBLISHED=0;
	const STATUS_PUBLISHED=1;
	
	public $media_id = 'id';
          
    /**
     * Returns the static model of the specified AR class.
     * @param string $className the class name
     * @return CmsAttachment the static model class
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
    	return 'cms_media';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
    		array('id, published', 'numerical', 'integerOnly'=>true),
            array('extension, filename, mimeType, byteSize, source', 'required'),
            array('byteSize', 'length', 'max'=>10),
            array('extension', 'length', 'max'=>50),
            array('filename, mimeType', 'length', 'max'=>255),
            array('id, created, extension, filename, mimeType, byteSize, source', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
        
        );
    }

        /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('CmsModule.core', 'Id'),
            'created' => Yii::t('CmsModule.core', 'Created'),
            'extension' => Yii::t('CmsModule.core', 'Extension'),
            'filename' => Yii::t('CmsModule.core', 'Filename'),
            'mimeType' => Yii::t('CmsModule.core', 'Mime Type'),
            'byteSize' => Yii::t('CmsModule.core', 'Size (bytes)'),
            'source' => Yii::t('CmsModule.core', 'Source'),
            'published' => Yii::t('CmsModule.core', 'Published'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('extension',$this->extension,true);
        $criteria->compare('filename',$this->filename,true);
        $criteria->compare('mimeType',$this->mimeType,true);
        $criteria->compare('byteSize',$this->byteSize,true);

        return new CActiveDataProvider($this, array(
        	'criteria'=>$criteria,
        ));
    }
        
    public function beforeSave() {
	    if ($this->isNewRecord)	$this->published = self::STATUS_PUBLISHED;
	 
	    return parent::beforeSave();
	}
        
    /**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		//Remove file from system
		if (file_exists($this->source))	
			unlink($this->source);
			
		//remove from join table
		$this->deleteContentJoin($this->id);
		
	}

	private function deleteContentJoin($id)
	{
	    $table='cms_content_media';
	    $this->getDbConnection()->createCommand('DELETE FROM '.$table.' WHERE media_id = '.$id)->execute();
	}

    /**
     * Returns the URL to this attachment.
     * @return string the URL
     */
    public function getUrl()
    {
    	return baseUrl().'/'.$this->source;
    }

    /**
     * Returns the tag for this attachment.
     * @return string the tag
     */
    public function renderTag()
    {
    	return strpos($this->mimeType, 'image') !== false ? '{{image:'.$this->id.'}}' : '{{file:'.$this->id.'}}';
    }

    /**
     * Returns the filename for this attachment.
     * @return string the filename
     */
    public function resolveName()
    {
    	return substr($this->filename, 0, strrpos($this->filename, '.')).'-'.$this->id.'.'.strtolower($this->extension);
    }
        
    public function adminActions()
    {
    	$result = l('Edit',array('/cms/media/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/media/delete",array('id'=>$this->id))));
    	
    	return $result;
    }
    
    public function render($array=array())
    {
    	if(empty($array)) {
	    	$new_path = $this->source;
    	} else {
    	if($array['file'])
	    		$file = $array['file'];
	    	else
	    		$file = $this->source;
	    		
			$image = Yii::app()->image->load($file);
			
			if($array['smart_resize'])
				$image->smart_resize($array['width'], $array['height']);
			else
				$image->resize($array['width'], $array['height']);
				
			if($array['rotate']) $image->rotate($array['rotate']);
			if($array['quality']) $image->quality($array['quality']);
			if($array['sharpen']) $image->sharpen($array['sharpen']);
			
			$path_parts = pathinfo($file);
			if($array['width']) $path_parts['filename'] .= '_'.$array['width'];
			if($array['height']) $path_parts['filename'] .= '_'.$array['height'];
			
			$new_path = $path_parts['dirname'].'/'.$path_parts['filename'].'.'.$path_parts['extension'];
			
			$image->save($new_path);
		}
		
		return Yii::app()->request->baseUrl.'/'.$new_path;
    }
    
}
