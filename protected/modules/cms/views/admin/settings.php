		<div class="row-fluid">
          <ul class="breadcrumb">
            <li><a href="#">Home</a> <span class="divider">/</span></li>
            <li class="active">Settings</li>
          </ul>
          <h2 class="heading">
                Global Settings
          </h2>
        </div>
        
        <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'settings-form',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('class'=>'form-horizontal')
		)); ?>
		<div class="row-fluid">
          <div class="widget widget-padding span12">
            <div class="widget-header">
              <i class="icon-list-alt"></i><h5>Settings</h5>
              <div class="widget-buttons">
                  <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
              </div>
            </div>
            
            <? foreach($settings as $row): ?>
            <div class="widget-body">
              <div class="widget-forms clearfix">
                  <div class="control-group">
                  	<?php echo $form->labelEx($model, $row->define); ?>
                    <div class="controls">
                      <input class="span7" type="text" name="CmsSettings[<?=$row->define?>]" value="<?=$row->value?>">
                      <span class="help-inline"><?php echo $form->error($model, $row->define); ?></span>
                    </div>
                  </div>
              </div>
            </div>
            <? endforeach; ?>
            
            <div class="widget-footer">
               <button class="btn btn-primary" type="submit">Save</button>
               <button class="btn" type="button">Cancel</button>
            </div>
          </div>
        </div>  
        <?php $this->endWidget(); ?>