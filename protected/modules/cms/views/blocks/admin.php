<div class="row-fluid">
	<h2 class="heading">Manage Blocks</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-align-left"></i>
              <h5>Manage Blocks</h5>
              <div class="widget-buttons">
              	<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128, 'class'=>'select2-input', 'placeholder'=>'Search block')); ?>
              		</div>
              	<?php $this->endWidget(); ?>
              </div>
            </div>  
            <div class="widget-body">
            	<!-- http://www.yiiframework.com/doc/api/1.1/CGridView#cssFile-detail -->
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'film-grid',
					'itemsCssClass'=>'table table-striped table-bordered dataTable',
					//'enablePagination'=>false,
					'dataProvider'=>$model->search(),
					//'filter'=>$model,
					'cssFile'=>false,
					'columns'=>array(
						'name',
						//'parentId',
						array(
							'name'=>'parentId',  
							'value'=>'CHtml::link($data->parent->name, array("pages/update", "id"=>$data->parent->id));',
							'header'=>'Parent',
							'type'=>'raw',
						),
						'published:boolean',
						array(
							'header'=>'Actions',
							'value'=>'$data->adminActions()',
							'type'=>'raw',
						),
					),
				)); ?>
            </div>
	</div>
</div>