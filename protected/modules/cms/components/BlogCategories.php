<?php

Yii::import('zii.widgets.CPortlet');

class BlogCategories extends CPortlet
{
	//public $title='Tags';
	public $limit=20;

	protected function renderContent()
	{
		$categories=CmsBlog::listActiveCategories($this->limit)->queryAll();

		$view = 'webroot.themes.'.Yii::app()->theme->name.'.views.blog._categories';
		$this->render($view, array(
			'categories'=>$categories,
		));
	}
}