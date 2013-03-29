<?php
/**
 * Cms base controller class that provides various base functionality.
 * All cms controllers should be extended from this class.
 */
class CmsController extends CController
{
        
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
	/* SEO Vars */
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageAuthor='';
    public $pageRobotsIndex = true;
    public $pageOgTitle = '';
    public $pageOgDesc = '';
    public $pageOgImage = '';
	
	public function init() 
	{	
		// Use this to get referrer: Yii::app()->user->returnUrl;
		Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
	}
	
	public function getMetaData()
    {
    	if(empty($this->pageTitle)) $this->pageTitle = Yii::app()->setting->getValue('site_name');
		else $this->pageTitle=$this->pageTitle.' - '.Yii::app()->setting->getValue('site_name');
		
		if(empty($this->pageDescription)) $this->pageDescription=Yii::app()->setting->getValue('home_meta_description');
		if(empty($this->pageKeywords)) $this->pageKeywords=Yii::app()->setting->getValue('home_meta_keywords');
		
        echo '<title>'.CHtml::encode($this->pageTitle).'</title>';
        Yii::app()->clientScript->registerMetaTag($this->pageDescription, 'description');
        Yii::app()->clientScript->registerMetaTag($this->pageKeywords, 'keywords');
        Yii::app()->clientScript->registerMetaTag($this->pageAuthor, 'author');
    }
    
    //returns page name, to genrate Block widget for cms page
    public function getPageData()
	{ 
		if(Yii::app()->controller->id=='site')
			$page_name = Yii::app()->controller->action->id;
		else
			$page_name = Yii::app()->controller->id.'-'.Yii::app()->controller->action->id;
	
		$result = CmsPage::model()->findByAttributes(array('name'=>$page_name));

		if($result){
			return $result;
		}
	}
	
	public function bodyClass()
	{
		if(Yii::app()->controller->id=='site')
			$page_name = Yii::app()->controller->action->id;
		else
			$page_name = Yii::app()->controller->id.'-'.Yii::app()->controller->action->id;
			
		return $page_name;
	}	

}