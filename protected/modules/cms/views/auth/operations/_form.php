<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>
	<? if($form->errorSummary($model)): ?>
	<div class="row-fluid">
      <div class="widget widget-padding span12">
        <div class="widget-header">
          <i class="icon-external-link"></i><h5>Errors:</h5>
          <div class="widget-buttons">
              <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
          </div>
        </div>
        <div class="widget-body">
          <div class="alert alert-info" style="margin:0;">
            <?php echo $form->errorSummary($model); ?>
          </div>
        </div>
      </div>
    </div>
    <? endif; ?>
    
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> <?php echo Yii::app()->user->getFlash('success'); ?> 
</div>
<?php endif; ?>

<div class="row-fluid">
  <div class="widget widget-padding span12">
    <div class="widget-header">
      <i class="icon-list-alt"></i><h5>Basic Inputs</h5>
      <div class="widget-buttons">
          <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
      </div>
    </div>
    <div class="widget-body">
      <div class="widget-forms clearfix">
        <form class="form-horizontal">
	          <div class="control-group">
	          	<?php echo $form->labelEx($model,'name'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128)); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'name'); ?></span>
	          	</div>
	          </div>
	          
	          <div class="control-group">
	          	<?php echo $form->labelEx($model,'description'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'description',array('size'=>80,'maxlength'=>128)); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'description'); ?></span>
	          	</div>
	          </div>
        </form>
      </div>
    </div>
    <div class="widget-footer">
       <?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary')); ?>
    </div>
  </div>
</div>

<?php $this->endWidget(); ?>