<?php

Yii::import('cms.models.*');
        
/**
 * Cms application component that allows for application-wide access to the cms.
 */
class Cms extends CApplicationComponent
{
	/**
     * @var string the allowed attachment files types.
     */
    //public $allowedFileTypes = 'jpg, gif, png';
        
    /**
     * @var integer the maximum allowed attachment file size in bytes.
     */
    //public $allowedFileSize = 1024;
   
    /**
     * @var string the path for saving attached files.
     */
    //public $attachmentPath = '/files/cms/attachments/';
        
	/**
     * @var string the application layout to use with the cms.
     */
    //public $appLayout = 'application.views.layouts.main';
        
    /**
     * @var string the template to use for node headings.
     */
    public $headingTemplate = '<h1 class="heading">{heading}</h1>';
        
	/**
     * @var string the template to use for page titles.
     */
    public $pageTitleTemplate = ' - {title}';
        
	/**
     * @var string the template to use for widget headings.
     */
    public $widgetHeadingTemplate = '<h3 class="heading">{heading}</h3>';
        
	/**
	 * @var array the renderer configuration.
	 */
	public $renderer = array('class'=>'cms.components.CmsBaseRenderer');
	
	private $_assetsUrl;

	/**
     * Initializes the component.
     */
    public function init()
    {
        parent::init();
        
        // Create the renderer.
        $this->renderer = Yii::createComponent($this->renderer);
    }
    
    public function getAssetsUrl()
	{
	    if ($this->_assetsUrl === null)
	        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
	            Yii::getPathOfAlias('cms.assets') );
	    return $this->_assetsUrl;
	}
    
    /**
     * Creates the URL to a content page.
     * @param string $name the content name
     * @param array $params additional parameters
     * @return string the URL
     */
    public function createUrl($name, $params=array())
    {
            $page = $this->loadPage($name);
            if($page)
            	return $page->getUrl($params);
    }
    
    /**
     * Loads a node model.
     * @param string $name the node name
     * @return CmsNode the model
     */
	public function loadBlock($name, $parent)
	{
		$block = CmsBlocks::model()->published()->findByAttributes(array('name'=>$name,'parentId'=>$parent));
		return $block;
	}
        
	/**
     * Loads a node model.
     * @param string $name the node name
     * @return CmsNode the model
     */
	public function loadPage($name)
	{
		$page = CmsPage::model()->findByAttributes(array('name'=>$name));
		return $page;
	}
	
	/**
     * Creates a new node model.
     * @param string $name the node name
     * @return boolean whether the node was created
     * @throws CException if the node could not be created
     */
	/*protected function createNode($name)
    {
        if (!$this->autoCreate)
                throw new CException(__CLASS__.': Failed to create node. Node creation is disabled.');

        // Validate the node name before creation.
        if (preg_match('/^[\w\d\._-]+$/i', $name) === 0)
                throw new CException(__CLASS__.': Failed to create node. Name "'.$name.'" is invalid.');

        $node = new CmsNode();
        $node->name = $name;
        return $node->save(false);
    }*/
    
    public function uploadMedia()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        
        //Check if upload dir is there or create one
    	$file_path = "files/".date("Y-m-W")."/";
    	$upload_path = $file_path;
    	if(!is_dir($upload_path)) mkdir($upload_path, 0777, true);
 
        $folder=$upload_path;// folder for uploaded files
        $allowedExtensions = array("jpg");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        
        //insert into database
        if($result['success']==1) {
        	$return = $this->insertFile($result);
        	return $return;
        }
    }
    
    private function insertFile($result) 
	{	
		$model = new CmsMedia;
		$model->attributes = $result;
		if ($model->save())
		{
			$result['media_id'] = $model->id;
			return htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		}
	}
	
	public function sisyphus()
	{
		//sisyphus uses Local Storage to prevent your work being lost in Forms
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->cms->assetsUrl.'/css/alertify.css');
		$cs->registerScriptFile(Yii::app()->cms->assetsUrl.'/js/sisyphus.js', CClientScript::POS_END );
		$cs->registerScriptFile(Yii::app()->cms->assetsUrl.'/js/alertify.min.js', CClientScript::POS_END );
		
		$cs->registerScript(
		'sisyphus',
		'$("form").sisyphus({
			timeout: 15,
			autoRelease: true,
			onSave: function() {
				alertify.log( "Data saved to Local Storage", "info" );
			},
			onRestore: function() {
				alertify.log( "Data restored from Local Storage", "success" );
			},
			onRelease: function() {
				//alertify.log( "Data are removed from Local Storage", "error" );
			}		
		});',
		CClientScript::POS_END ); 
	}

}
