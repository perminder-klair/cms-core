<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-form',
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
    	<div class="widget widget-padding span12" id="wizard">
            <div class="widget-header">
              <ul class="nav nav-tabs">
                <li><a href="#validate_tab1" data-toggle="tab">Basic Info</a></li>
                <li><a href="#validate_tab2" data-toggle="tab">Password</a></li>
              </ul>
            </div>
            <div class="widget-body">
                <div class="tab-content">
                
                
                  <div class="tab-pane" id="validate_tab1">
                    <h4>Wizard w/ simple validation</h4>
                    <hr>
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'username'); ?>
			          	<div class="controls">
			          		<?php echo $form->textField($model,'username',array('size'=>80,'maxlength'=>128)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'username'); ?></span>
			          	</div>
			          	
			          </div>
			          
		          	  <div class="control-group">
			          	<?php echo $form->labelEx($model,'email'); ?>
			          	<div class="controls">
			          		<?php echo $form->textField($model,'email',array('size'=>80,'maxlength'=>128)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'email'); ?></span>
			          	</div>
			          	
			          </div>
		          		
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'status'); ?>
			          	<div class="controls">
		                    <?=$form->dropDownList($model,'status',CmsLookup::items('UserStatus'), array('class'=>'span7'));?>
			          		<span class="help-inline"><?php echo $form->error($model,'status'); ?></span>
			          	</div>
			          </div>
			          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'level'); ?>
			          	<div class="controls">
		                    <?=$form->dropDownList($model,'level',CmsLookup::items('UserLevel'), array('class'=>'span7'));?>
			          		<span class="help-inline"><?php echo $form->error($model,'level'); ?></span>
			          	</div>
			          </div>
                  </div>
                  

                  <div class="tab-pane" id="validate_tab2">
                  
                	  <div class="control-group">
			          	<?php echo $form->labelEx($model,'new_password'); ?>
			          	<div class="controls">
			          		<?php echo $form->passwordField($model,'new_password',array('size'=>80,'maxlength'=>128)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'new_password'); ?></span>
			          	</div>
			          </div>
			          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'new_password_repeat'); ?>
			          	<div class="controls">
			          		<?php echo $form->passwordField($model,'new_password_repeat',array('size'=>80,'maxlength'=>128)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'new_password_repeat'); ?></span>
			          	</div>
			          </div>
			          
                  </div>
                  
                </div>  
            </div>
            <div class="widget-footer">
              <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
            </div>
          </div>
     </div>

<?php $this->endWidget(); ?>