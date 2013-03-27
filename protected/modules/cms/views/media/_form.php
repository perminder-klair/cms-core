<?php
/* @var $this BlocksController */
/* @var $model Blocks */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'film-form',
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

<div class="row-fluid">
  <div class="widget widget-padding span12">
    <div class="widget-header">
      <i class="icon-list-alt"></i><h5>Fields with <span class="required">*</span> are required.</h5>
      <div class="widget-buttons">
          <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
      </div>
    </div>
    <div class="widget-body">
      <div class="widget-forms clearfix">
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'published'); ?>
	          	<div class="controls">
	          		<?php echo $form->dropDownList($model,'published', CmsLookup::items('MediaStatus')); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'published'); ?>
</span>
	          	</div>
	          	
	          </div>
	          
          	      
      </div>
    </div>
    <div class="widget-footer">
    	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
    	<a href="<?=$model->getUrl();?>"><button class="btn" type="button">Preview</button></a>
    </div>
  </div>
</div>  

<?php $this->endWidget(); ?>