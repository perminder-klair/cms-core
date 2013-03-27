<?php

Yii::import('zii.widgets.CPortlet');

class TagCloud extends CPortlet
{
	public $title='Tags';
	public $maxTags=20;

	protected function renderContent()
	{
		$tags=CmsTag::model()->findTagWeights($this->maxTags);

		foreach($tags as $tag=>$weight)
		{
			//$link=CHtml::link(CHtml::encode($tag), array('/cms/blog/index','tag'=>$tag));
			$link = '<a href="'.Yii::app()->createUrl('cms/blog/index', array('tag'=>$tag)).'">'.$tag.'</a>';
			echo CHtml::tag('span', array(
				'class'=>'tag',
				'style'=>"font-size:{$weight}pt",
			), $link)."\n";
		}
	}
}