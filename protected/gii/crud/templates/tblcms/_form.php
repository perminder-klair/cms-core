<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>\n"; ?>

	<?php echo "<?php if( \$form->errorSummary(\$model)  ) { ?>\n"; ?>
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
            <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo "<?php } ?>\n"; ?>

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
      
        	<?php
			foreach($this->tableSchema->columns as $column)
			{
				if($column->autoIncrement)
					continue;
			?>
	          <div class="control-group">
	          	<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
	          	<div class="controls">
	          		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	          		<span class="help-inline"><?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?></span>
	          	</div>
	          	
	          </div>
          	<?php
			}
			?>
         
      </div>
    </div>
    <div class="widget-footer">
    	<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>\n"; ?>
    </div>
    
  </div>
</div>  

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>