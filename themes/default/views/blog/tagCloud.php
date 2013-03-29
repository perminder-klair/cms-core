<?php foreach($tags as $tag=>$weight): ?>
	<? $link = '<a href="'.Yii::app()->createUrl('cms/blog/index', array('tag'=>$tag)).'">'.$tag.'</a>'; ?>
	<?=CHtml::tag('span', array(
		'class'=>'tag',
		'style'=>"font-size:{$weight}pt",
	), $link)."\n";?>
<?php endforeach; ?>