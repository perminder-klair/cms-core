<?php

class CmsModule extends CWebModule
{

	/**
     * @var string the name of the default controller
     */
    public $defaultController = 'admin';
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'cms.models.*',
			'cms.components.*',
		));
		
		//$controller->layout = 'webroot.protected.views.layouts.admin'; // path to your view
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			//$layoutPath= Yii::getPathOfAlias('application.views.layouts');
            //$this->setLayoutPath($layoutPath);

			
			return true;
		}
		else
			return false;
	}
}
