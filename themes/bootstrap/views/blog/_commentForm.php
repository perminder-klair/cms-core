<div class="row-fluid">
	<div class="span8">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'comment-form',
			'enableAjaxValidation'=>true,
		)); ?>
		
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		
			<div class="row-fluid">
				<?php echo $form->labelEx($model,'author'); ?>
				<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'author'); ?>
			</div>
		
			<div class="row-fluid">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			
			<div class="row-fluid">
				<?php echo $form->labelEx($model,'content'); ?>
				<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'content'); ?>
			</div>
		
			<div class="row-fluid">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save', array('class'=>'btn')); ?>
			</div>
		
		<?php $this->endWidget(); ?>

	</div>
</div><!-- form -->