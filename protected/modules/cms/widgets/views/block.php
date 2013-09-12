<div class="cms-block block-<?php echo $model->name; ?>">
	<?php $this->beginWidget('CHtmlPurifier'); ?>
		<?php echo $content ?>
	<?php $this->endWidget(); ?>

    <div style="clear:both;"></div>
</div>