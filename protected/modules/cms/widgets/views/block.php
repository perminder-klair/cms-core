<div class="cms-block block-<?=$model->name;?>">
	<div class="block-content">
		<?php $this->beginWidget('CHtmlPurifier'); ?>
			<?php echo $content ?>
		<?php $this->endWidget(); ?>
	</div>
</div>