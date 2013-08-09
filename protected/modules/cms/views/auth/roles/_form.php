<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'roles-form',
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
  <div class="widget widget-padding span12">
    <div class="widget-header">
      <i class="icon-list-alt"></i><h5>Basic Inputs</h5>
      <div class="widget-buttons">
          <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
      </div>
    </div>
    <div class="widget-body">
      <div class="widget-forms clearfix">
      
      	<?php echo $form->textFieldRow($model, 'name'); ?>
        	 
        <?php echo $form->textFieldRow($model, 'description'); ?>

      </div>
    </div>
    <div class="widget-footer">
       <?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary')); ?>
    </div>
  </div>
</div>

<?php $this->endWidget(); ?>

<div class="row-fluid">
<div class="widget widget-padding span12">
  <div class="widget-header">
    <i class="icon-align-left"></i>
    <h5>Permissions</h5>
    <div class="widget-buttons">
    	<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'operation-form',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('class'=>'form-horizontal')
		)); ?>
    	<?php echo $form->dropDownList($formModel, 'items', $allOperations, array('label'=>false)); ?>
    	<?php echo CHtml::submitButton('Add', array('class'=>'btn btn-primary')); ?>
      <?php $this->endWidget(); ?>
    </div>
  </div>  
  <div class="widget-body">
  
		<div class="row-fluid">
          <div class="span12">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($descendants as $row): ?>
                <tr>
                  <td><?php echo $row['item']->description; ?></td>
                  <td><?php echo AuthItemForm::getItemTypeText($row['item']->type); ?></td>
                  <td>
	                <?php echo l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/auth/removeChild",array('itemName'=>$model->name,'childName'=>$row['item']->name)))); ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div> 
       
     </div> <!-- /widget-body -->
  </div> <!-- /widget -->
</div> <!-- /row-fluid -->