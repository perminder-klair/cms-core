<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'categories-form',
'type'=>'horizontal',
'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>

	<?php if( $form->errorSummary($model)  ) { ?>
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
    <?php } ?>
    
<?php if(\Yii::app()->user->hasFlash('success')):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong>  
</div>
<?php endif; ?>

<div class="row-fluid">
  <div class="widget widget-padding span12" id="wizard">
		
    <div class="widget-header">
      <ul class="nav nav-tabs">
        <li><a href="#validate_tab1" data-toggle="tab">Basic Info</a></li>
      </ul>
    </div>
    <div class="widget-body">
      <div class="tab-content">     
        
      	<div class="tab-pane" id="validate_tab1">
      	
      			<?php echo $form->textFieldRow($model, 'title'); ?>
      			
      			<?php echo $form->dropDownListRow($model, 'parent', CmsLookup::items('CategoryStatus')); ?>
      			
      			<?php echo $form->dropDownListRow($model, 'category_type', CmsLookup::items('CategoryType')); ?>
	          	
        </div>
      	 
      </div>
    </div>
    <div class="widget-footer">
    	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
    </div>
    
  </div>
</div>  

<?php $this->endWidget(); ?>
