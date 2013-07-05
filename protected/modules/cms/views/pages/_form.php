<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'page-form-'.$model->id,
'type'=>'horizontal',
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
                <? if($model->isCmsPage()): ?>
	                <li><a href="#validate_tab2" data-toggle="tab">Media</a></li>
	                <li><a href="#validate_tab3" data-toggle="tab">Parent</a>
	                <li><a href="#validate_tab4" data-toggle="tab">Style</a></li>
                <? endif; ?>
                <li><a href="#validate_tab5" data-toggle="tab">SEO</a></li>
              </ul>
            </div>
            <div class="widget-body">
                <div class="tab-content">
                
                
                  <div class="tab-pane" id="validate_tab1">			          	

				          <?php echo $form->textFieldRow($model, 'heading'); ?>
			          		
			          	  <? if($model->isCmsPage()): ?>
				          <div class="control-group">
				          	<?php echo $form->labelEx($model,'body'); ?>
				          	<div class="controls">
				          		<?php $this->widget('ext.tinymce.TinyMce', array(
								    'model' => $model,
								    'attribute' => 'body',
								    'htmlOptions' => array(
								        'rows' => 6,
								        'cols' => 60,
								    ),
								)); ?>
				          		<span class="help-inline"><?php echo $form->error($model,'body'); ?></span>
				          	</div>
				          </div>
				          <? endif; ?>
				          
			          	<? if($model->isCmsPage()): ?>
			          		<?php echo $form->dropDownListRow($model, 'status', CmsLookup::items('PageStatus')); ?> 
				        <? endif; ?>
				          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'tags'); ?>
			          	<div class="controls">
		                    <?php $this->widget('CAutoComplete', array(
								'model'=>$model,
								'attribute'=>'tags',
								'url'=>array('/cms/blog/suggestTags'),
								'multiple'=>true,
								'htmlOptions'=>array('size'=>50),
							)); ?>
			          		<span class="help-inline">Please separate different tags with commas. <?php echo $form->error($model,'tags'); ?></span>
			          	</div>
			          </div>
				          
                  </div>
                  
                  
                  <div class="tab-pane" id="validate_tab2">                   
                    <!-- Media manager here -->
                  	<?php $this->widget('cms.widgets.CmsMediaManager', array('model'=>$model, 'type'=>'page')) ?>	               
                  </div>
                  
                  <div class="tab-pane" id="validate_tab3">  
                  		<?php echo $form->dropDownListRow($model, 'parentId', $model->getParentOptionTree()); ?>     
                  </div>
                  
                  <div class="tab-pane" id="validate_tab4">      
                  		<? if($model->isCmsPage()): ?>
                  			<?php echo $form->dropDownListRow($model, 'layout', Yii::app()->cms->scanPagesDir()); ?>
				        <? endif; ?>
                  </div>
                  
                  <div class="tab-pane" id="validate_tab5">                   

	                  <?php echo $form->textFieldRow($model, 'metaDescription'); ?>
	                  
	                  <?php echo $form->textFieldRow($model, 'name'); ?>
                  
                </div>  

            </div>
            <div class="widget-footer">
            	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
              <? if($model->isCmsPage()): ?>
              	<a href="<?=$model->getUrl();?>" target="_blank"><button class="btn" type="button">Preview</button></a>
              <? endif; ?>
            </div>
          </div>
     </div>

<?php $this->endWidget(); ?>