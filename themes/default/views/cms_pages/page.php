<div class="cms-page">
	
	<h1><?=$model->getHeading();?></h1>
	<div class="page-content"><?php echo $content ?></div>
	
	<div class="media">
		<? foreach($model->media as $img): ?>
			<?=CHtml::image($img->render(array('height'=>350, 'width'=>200, 'smart_resize'=>true, 'rotate'=>90)));?>
		<? endforeach; ?>
	</div>
	
	<div class="child">
		<? foreach($children as $page): ?>
			<a href="<?=$page->getUrl();?>"><?=$page->getHeading();?></a>
		<? endforeach; ?>
	</div>

</div>