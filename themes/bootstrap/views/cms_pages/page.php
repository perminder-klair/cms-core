<div class="cms-page">
	
	<h1><?php echo $model->getHeading();?></h1>
	<div class="page-content"><?php echo $content ?></div>
	
	<div class="media">
		<?php foreach($model->media as $img): ?>
			<?php echo CHtml::image($img->render(array('height'=>350, 'width'=>200, 'smart_resize'=>true, 'rotate'=>90))); ?>
		<?php endforeach; ?>
	</div>
	
	<div class="child">
		<?php foreach($children as $page): ?>
			<a href="<?php echo $page->getUrl();?>"><?php echo $page->getHeading(); ?></a>
		<?php endforeach; ?>
	</div>

</div>