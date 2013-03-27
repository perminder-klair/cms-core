<?php

class CmsSetting extends CApplicationComponent
{
	/*
     *	Global site settings
     */
    public function getValue($key)
    {
        $model = CmsSettings::model()->findByAttributes(array('define'=>$key));
        return $model->value;
    }
    
    //Load JS files for frontend
	public function loadJs($jsFiles)
	{
		$baseUrl = Yii::app()->theme->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		//$cs->registerCoreScript('jquery.ui'); 
		foreach($jsFiles as $js) {
			$cs->registerScriptFile($baseUrl.'/js/'.$js.'.js', CClientScript::POS_END);
		}
	}
	
	//Load CSS files for frontend
	public function loadCss($cssFiles)
	{
		$baseUrl = Yii::app()->theme->baseUrl; 
		$cs = Yii::app()->getClientScript();
		foreach($cssFiles as $css) {
			$cs->registerCssFile($baseUrl.'/css/'.$css.'.css');
		}
	}
	
	//Load css and js files for admin panel
    public function getAdminScripts()
    {
    	$assets = Yii::app()->cms->assetsUrl;
    	//Inclode core CSS Files
        $cs = Yii::app()->getClientScript(); 
        $cs->registerCssFile($assets.'/css/bootstrap.css');
        $cs->registerCssFile($assets.'/css/theme.css');
        $cs->registerCssFile($assets.'/css/font-awesome.min.css');
        //to be removed
        $cs->registerCssFile($assets.'/css/alertify.css');
        $cs->registerCssFile($assets.'/css/datepicker.css');
        $cs->registerCssFile($assets.'/css/timepicker.css');
        $cs->registerCssFile($assets.'/css/facybox.css');
        
        //Inclode core JS Files
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui'); 
        $cs->registerScriptFile($assets.'/js/bootstrap.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/morris.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/raphael-min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.dataTables.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.masonry.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.imagesloaded.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.facybox.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.alertify.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.knob.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/fullcalendar.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.gritter.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.bootstrap.wizard.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.validate.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/bootstrap-timepicker.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/bootstrap-datepicker.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/bootstrap-colorpicker.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/select2.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/realm.js', CClientScript::POS_END);
        //to be removed
        $cs->registerScriptFile($assets.'/js/jquery.cookie.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/jquery.autocomplete.js', CClientScript::POS_END);
    }
}