<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'user-form',
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
    
<?php if(Yii::app()->user->hasFlash('success')):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> <?php echo Yii::app()->user->getFlash('success'); ?> 
</div>
<?php endif; ?>
    	
    <div class="row-fluid">
    	<div class="widget widget-padding span12" id="wizard">
            <div class="widget-header">
              <ul class="nav nav-tabs">
                <li><a href="#validate_tab1" data-toggle="tab">Basic Info</a></li>
                <li><a href="#validate_tab2" data-toggle="tab">Password</a></li>
                <li><a href="#validate_tab3" data-toggle="tab">Media</a></li>
              </ul>
            </div>
            <div class="widget-body">
                <div class="tab-content">
                
                  <div class="tab-pane" id="validate_tab1">

	              		<?php echo $form->textFieldRow($model, 'username'); ?>
                	
	              		<?php echo $form->textFieldRow($model, 'email'); ?>
                	
	              		<?php echo $form->dropDownListRow($model, 'status', CmsLookup::items('UserStatus')); ?>
	              		
	              		<?php if($model->userRole!='super') echo $form->dropDownListRow($model, 'userRole', $model->getRolesAsListData()); ?>
			          
                  </div>
                  

                  <div class="tab-pane" id="validate_tab2">
                  
                  		<?php echo $form->passwordFieldRow($model, 'new_password', array('class'=>'span3')); ?>
                  		
                  		<?php echo $form->passwordFieldRow($model, 'new_password_repeat', array('class'=>'span3')); ?>
			          
                  </div>
                  
                  <div class="tab-pane" id="validate_tab3"> 
                  	<!-- Media manager here -->
                  	<?php $this->widget('cms.widgets.CmsMediaManager', array('model'=>$model, 'type'=>'user')) ?>
                  </div>
                  
                </div>  
            </div>
            <div class="widget-footer">
            	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
            </div>
          </div>
     </div>

<?php $this->endWidget(); ?>