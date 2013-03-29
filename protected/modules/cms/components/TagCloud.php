<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
	//public $title='Tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags=CmsTag::model()->findTagWeights($this->maxTags);

		$view = 'webroot.themes.'.Yii::app()->theme->name.'.views.blog.tagCloud';
		$this->render($view, array(
			'tags'=>$tags,
		));
	}
}