<div class="row-fluid">
	Tags:
    <div class="span12">

		<?php foreach($tags as $tag=>$weight): ?>
			<?php $link = '<a href="'.Yii::app()->createUrl('cms/blog/index', array('tag'=>$tag)).'">'.$tag.'</a>'; ?>
			<?php echo CHtml::tag('span', array(
				'class'=>'tag label',
				'style'=>"font-size:{$weight}pt",
			), $link)."\n"; ?>
		<?php endforeach; ?>
	
	</div>
</div>