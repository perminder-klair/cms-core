<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'media-form',
'type'=>'horizontal',
'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>

	<?php if($form->errorSummary($model)): ?>
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
    <?php endif; ?>

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
	          	
	        <?php echo $form->dropDownListRow($model, 'published', CmsLookup::items('MediaStatus')); ?>
	        
	        <?php echo $form->dropDownListRow($model, 'media_type', CmsLookup::items('MediaType')); ?>
	          
      </div>
    </div>
    <div class="widget-footer">
    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
    </div>
  </div>
</div>  

<?php $this->endWidget(); ?>