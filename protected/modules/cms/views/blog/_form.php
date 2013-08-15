<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'blog-form-'.$model->id,
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
                <li><a href="#validate_tab2" data-toggle="tab">Media</a></li>
                <li><a href="#validate_tab5" data-toggle="tab">Categories</a></li>
                <li><a href="#validate_tab3" data-toggle="tab">SEO</a></li>
                <li><a href="#validate_tab4" data-toggle="tab">Revisions</a></li>
              </ul>
            </div>
            <div class="widget-body">
                <div class="tab-content">
                
                  <div class="tab-pane" id="validate_tab1">
                  
			          <?php echo $form->textFieldRow($model, 'title'); ?>
			          
		          	  <div class="control-group">
			          	<?php echo $form->labelEx($model,'content'); ?>
			          	<div class="controls">
			          		<?php $this->widget('ImperaviRedactorWidget', array(
                                // You can either use it for model attribute
                                'model' => $model,
                                'attribute' => 'content',

                                // or just for input field
                                //'name' => 'my_input_name',

                                // imperavi redactor [options](http://imperavi.com/redactor/docs/)
                                'options'=>array(
                                    'toolbar'=>'classic',
                                ),
                            )); ?>
			          		<span class="help-inline"><?php echo $form->error($model,'content'); ?></span>
			          	</div>
			          	
			          </div>
		          		
		          	  <?php echo $form->dropDownListRow($model, 'status', CmsLookup::items('PostStatus')); ?> 
			          
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
			          		<div class="input-append date span5 datepicker datepicker-basic" data-date="<?php echo date("d-m-Y", strtotime($model->date_start)); ?>" data-date-format="dd-mm-yyyy">
			          			<?php echo $form->textField($model,'date_start',array('size'=>16)); ?>
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

			          <?php echo $form->textFieldRow($model, 'slug'); ?>
			          
			          <?php echo $form->textFieldRow($model, 'metaDescription'); ?>
			          
                  </div>
                  
                  <div class="tab-pane" id="validate_tab4"> 
                  
                  		<?php if(count($model->revisions)<=0) { ?>
                  			<h5>No revisions found to restore.</h5>
                  		<?php } else { ?>
	                    <table class="table">
	                      <thead>
	                        <tr>
	                          <th>Date Created</th>
	                          <th>Author</th>
	                          <th>Actions</th>
	                        </tr>
	                      </thead>
	                      <tbody>
	                      	<?php foreach($model->revisions as $revision): ?>
	                        <tr>
	                          <td><?php echo $revision->revisionTime(); ?></td>
	                          <td><?php echo $revision->author->username; ?></td>
	                          <td><a href="<?php echo url("/cms/blog/restore/", array('id'=>$revision->id)); ?>">Restore</a></td>
	                        </tr>
	                        <?php endforeach; ?>
	                      </tbody>
	                    </table>
	                    <?php } ?>

                  </div>
                  
                  <div class="tab-pane form-horizontal" id="validate_tab5">
                  		
                  		<div class="control-group">
		                    <div class="controls" style="width: 250px;">
		                    	
		                    	<?php echo $form->checkBoxList($model, "blogCategories", $model->listAllCategories(),
        								array(
        									'labelOptions'=>array('class'=>'checkbox strong')
        								)); ?>
		                    </div>
		                </div>
                  		
                  </div> 
                  
                </div>  

            </div>
            <div class="widget-footer">
              <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
              <a href="<?php echo $model->getUrl();?>" target="_blank"><button class="btn" type="button">Preview</button></a>
            </div>
          </div>
     </div>

<?php $this->endWidget(); ?>