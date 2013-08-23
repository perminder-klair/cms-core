<?php

/**
 * Cms application component that allows for application-wide access to the cms.
 */
class Cms extends CApplicationComponent
{
	/**
	 * Cms Branding
	 */
	public $cmsName = 'Broome CMS';
	public $cmsLogo = '/img/logo.png'; //logo-tbl.png
	public $defaultGravatar = '/img/logo-gravatar.jpg'; //logo-tbl-gravatar.png
        
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
    
    public function uploadMedia()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        
        //Check if upload dir is there or create one
    	$file_path = "files/".date("Y-m-W")."/";
    	$upload_path = $file_path;
    	if(!is_dir($upload_path)) mkdir($upload_path, 0777, true);
 
        $folder=$upload_path;// folder for uploaded files
        $allowedExtensions = CmsMedia::allowedFileTypes();//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        
        //insert into database
        if(isset($result['success']) && $result['success']==1) {
        	return $this->insertFile($result);
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

    public function scanPagesDir()
    {
		$pages_dir = 'themes' . DIRECTORY_SEPARATOR . Yii::app()->theme->name . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'cms_pages' . DIRECTORY_SEPARATOR;
		
		$handle = opendir($pages_dir);
		while (false !== ($file = readdir($handle))) {
		    if ($file != "." && $file != ".." && ($pages_dir . $file)) { //is_dir
		    	$file = explode(".", $file);
		    	$array[$file[0]] = ucfirst($file[0]);
		    }
		}
		closedir($handle);
		
		return $array;
    }
    
    public function userGravatar()
    {
    	$user = Yii::app()->user->getDetails();
    	if($user->authorImage()){
			$this->widget('ext.yii-gravatar.YiiGravatar', array(
			    'email'=>$user->email,
			    'size'=>40,
			    'defaultImage'=>$user->authorImage(),
			    'secure'=>false,
			    'rating'=>'r',
			    'emailHashed'=>false,
			    'htmlOptions'=>array(
			        'alt'=>$user->getName().' Gravatar image',
			        'title'=>$user->getName().' Gravatar image',
			    )
			)); 
		} else
	    	return i(Yii::app()->cms->assetsUrl.$this->defaultGravatar, 'Gravatar');
    }
}
