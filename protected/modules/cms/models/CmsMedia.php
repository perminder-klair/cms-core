<?php

class CmsMedia extends CmsActiveRecord
{
	const STATUS_NOT_PUBLISHED=0;
	const STATUS_PUBLISHED=1;
	const TYPE_OTHER=0;
	const TYPE_FEATURED=1;
	const TYPE_CONTENT=2;
	const FILE_SIZE_LIMIT=1048567600;
	
	public $media_id = 'id';
	
	public static function allowedFileTypes()
	{
		return array('jpg', 'jpeg', 'png', 'bmp', 'pdf', 'doc', 'docx', 'txt');
	}
          
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
    		array('id, published, media_type', 'numerical', 'integerOnly'=>true),
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
            'media_type' => Yii::t('CmsModule.core', 'Media Type'),
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
	    if ($this->isNewRecord){
	    	$this->published = self::STATUS_PUBLISHED;
			$this->media_type=0;  
	    }
	    
	    //empty cache folder
        $this->empty_cache();
	 
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
		
		//empty cache folder
        $this->empty_cache();
		
	}
	
	//empty cache folder
	private function empty_cache()
	{
		$cache_dir = 'files/cache/';
        if(file_exists($cache_dir)) deleteDirectory($cache_dir, true);
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

    public function render($array=array(), $dummy=false)
    {
        if(isset($array['file']))
            $file = $array['file'];
        else
            $file = YiiBase::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->source;

        if(is_readable($file))
        {
            $config=array();

            if(isset($array['width']) && isset($array['height']))
            {
                if($array['smart_resize']) {
                    $config['smart_resize'] = array('width' => $array['width'], 'height' => $array['height']);
                    $config['crop'] = array('width'=>$array['width'], 'height'=>$array['height'], 'center', 'center');
                } else
                    $config['resize'] = array('width' => $array['width'], 'height' => $array['height']);
            }

            if(isset($array['rotate'])) $config['rotate'] = array('degrees' => $array['rotate']);
            if(isset($array['sharpen'])) $config['sharpen'] = $array['sharpen'];
            if(isset($array['background'])) $config['background'] = $array['background'];
            if(isset($array['type'])) $config['type'] = $array['type'];
            if(isset($array['quality'])) $config['quality'] = $array['quality'];

            $thumb = Yii::app()->easyImage->thumbSrcOf($file, $config);

            return $thumb;
        }

        if($dummy)
            if(isset($array['width']) && isset($array['height']))
                return "http://dummyimage.com/{$array['width']}x{$array['height']}/cccccc/969696.png&text=image+not+found";

        return false;
    }
    
    public function getMedia($id)
    {
	    return CmsMedia::model()->findByPk($id);
    }
}
