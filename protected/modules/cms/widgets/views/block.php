<div class="cms-block block-<?=$model->name;?>">
	<?php $this->beginWidget('CHtmlPurifier'); ?>
		<?php echo $content ?>
	<?php $this->endWidget(); ?>
</div>