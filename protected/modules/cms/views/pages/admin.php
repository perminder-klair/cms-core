<div class="row-fluid">
	<h2 class="heading">Manage Pages
		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href='create'"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-file-alt"></i>
              <h5>Manage Pages</h5>
              <div class="widget-buttons">
              	<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			<?php echo $form->textField($model,'heading',array('size'=>60,'maxlength'=>128, 'class'=>'select2-input', 'placeholder'=>'Search page')); ?>
              		</div>
              	<?php $this->endWidget(); ?>
              </div>
            </div>  
            <div class="widget-body">

				<div class="widget-tasks-assigned">
                	<ul>
                		<?php $model->renderTree(); ?>
                	</ul>
                </div>
              
            </div>
	</div>
</div>