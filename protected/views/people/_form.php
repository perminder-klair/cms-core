<?php
/* @var $this PeopleController */
/* @var $model People */
/* @var $form CActiveForm */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'people-form',
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
        <li><a href="#validate_tab2" data-toggle="tab">Media</a></li>
      </ul>
    </div>
    <div class="widget-body">
      <div class="tab-content">     
        
      	<div class="tab-pane" id="validate_tab1">
        		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'title'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'title'); ?>
</span>
	          	</div>
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'created'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'created'); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'created'); ?>
</span>
	          	</div>
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'updated'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'updated'); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'updated'); ?>
</span>
	          	</div>
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'listing_order'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'listing_order'); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'listing_order'); ?>
</span>
	          	</div>
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'active'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'active'); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'active'); ?>
</span>
	          	</div>
	          	
	          </div>
          		          <div class="control-group">
	          	<?php echo $form->labelEx($model,'deleted'); ?>
	          	<div class="controls">
	          		<?php echo $form->textField($model,'deleted'); ?>
	          		<span class="help-inline"><?php echo $form->error($model,'deleted'); ?>
</span>
	          	</div>
	          	
	          </div>
          	      	</div>
      	
      	<div class="tab-pane" id="validate_tab2"> 
	      	<!-- Media manager here -->
	      	<?php $this->widget('cms.widgets.CmsMediaManager', array('model'=>$model, 'type'=>'people')) ?>
	    </div>
      	 
      </div>
    </div>
    <div class="widget-footer">
    	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
    </div>
    
  </div>
</div>  

<?php $this->endWidget(); ?>
