<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blog-form-'.$model->id,
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
                <li><a href="#validate_tab2" data-toggle="tab">Media</a></li>
                <li><a href="#validate_tab3" data-toggle="tab">SEO</a></li>
                <li><a href="#validate_tab4" data-toggle="tab">Revisions</a></li>
              </ul>
            </div>
            <div class="widget-body">
                <div class="tab-content">
                
                  <div class="tab-pane" id="validate_tab1">
                  
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'title'); ?>
			          	<div class="controls">
			          		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>70)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'title'); ?></span>
			          	</div>			          	
			          </div>
			          
		          	  <div class="control-group">
			          	<?php echo $form->labelEx($model,'content'); ?>
			          	<div class="controls">
			          		<?php $this->widget('ext.tinymce.TinyMce', array(
								    'model' => $model,
								    'attribute' => 'content',
								    'htmlOptions' => array(
								        'rows' => 6,
								        'cols' => 60,
								    ),
								)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'content'); ?></span>
			          	</div>
			          	
			          </div>
		          		
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'status'); ?>
			          	<div class="controls">
		                    <?=$form->dropDownList($model,'status',CmsLookup::items('PostStatus'), array('class'=>'span7'));?>
			          		<span class="help-inline"><?php echo $form->error($model,'status'); ?></span>
			          	</div>
			          </div>
			          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'tags'); ?>
			          	<div class="controls">
		                    <?php $this->widget('CAutoComplete', array(
								'model'=>$model,
								'attribute'=>'tags',
								'url'=>array('suggestTags'),
								'multiple'=>true,
								'htmlOptions'=>array('size'=>175),
							)); ?>
			          		<span class="help-inline">Please separate different tags with commas. <?php echo $form->error($model,'tags'); ?></span>
			          	</div>
			          </div>
			          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'date_start'); ?>
			          	<div class="controls">
			          		<div class="input-append date span5 datepicker datepicker-basic" data-date="<?=date("d-m-Y", strtotime($model->date_start));?>" data-date-format="dd-mm-yyyy">
			          			<?php echo $form->textField($model,'date_start',array('size'=>16)); ?>
	                        	<!--<input size="16" type="text" value="<?=date("d-m-Y", strtotime($model->date_start));?>">-->
	                        	<span class="add-on"><i class="icon-th"></i></span>
	                        </div>
			          		<span class="help-inline"><?php echo $form->error($model,'date_start'); ?></span>
			          	</div>			          	
			          </div>
			          
                  </div>
                  
                  <div class="tab-pane" id="validate_tab2"> 
                  	<!-- Media manager here -->
                  	<?php $this->widget('cms.widgets.CmsMediaManager', array('model'=>$model, 'type'=>'blog')) ?>
                  </div>
                  
                   <div class="tab-pane" id="validate_tab3"> 
                   
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'slug'); ?>
			          	<div class="controls">
			          		<?php echo $form->textField($model,'slug',array('size'=>80,'maxlength'=>70)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'slug'); ?></span>
			          	</div>   	
			          </div>
			          
			          <div class="control-group">
			          	<?php echo $form->labelEx($model,'metaDescription'); ?>
			          	<div class="controls">
			          		<?php echo $form->textField($model,'metaDescription',array('size'=>80,'maxlength'=>160)); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'metaDescription'); ?></span>
			          	</div>   	
			          </div>
			          
                  </div>
                  
                  <div class="tab-pane" id="validate_tab4"> 
                  
                  		<? if(count($model->revisions)<=0) { ?>
                  			<h5>No revisions found to restore.</h5>
                  		<? } else { ?>
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>Date Created</th>
	                          <th>Author</th>
	                          <th>Actions</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                      	<? foreach($model->revisions as $revision): ?>
	                        <tr>
	                          <td><?=$revision->revisionTime();?></td>
	                          <td><?=$revision->author->username;;?></td>
	                          <td><a href="<?=url("/cms/blog/restore/", array('id'=>$revision->id));?>">Restore</a></td>
	                        </tr>
	                        <? endforeach; ?>
	                      </tbody>
	                    </table>
	                    <? } ?>
	                    
	                    
                  </div>
                  
                </div>  

            </div>
            <div class="widget-footer">
              <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
              <a href="<?=$model->getUrl();?>" target="_blank"><button class="btn" type="button">Preview</button></a>
            </div>
          </div>
     </div>

<?php $this->endWidget(); ?>