<div class="row-fluid">
	<h2 class="heading">Manage Users
		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href='create'"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-group"></i>
              <h5>Manage User</h5>
              <div class="widget-buttons">
              	<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128, 'class'=>'select2-input', 'placeholder'=>'Search user')); ?>
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
					'ajaxUpdate' => false,
					'dataProvider'=>$model->search(),
					//'filter'=>$model,
					'cssFile'=>false,
					'columns'=>array(
						array(
							'name'=>'username',
							'value'=>'CHtml::link($data->username, array("user/update", "id"=>$data->id));',
							'header'=>'Username',
							'type'=>'raw',
						),
						array(
							'header'=>'Status',
							'value'=>'$data->adminStatus()',
							'type'=>'raw',
						),
						array(
							'header' => 'Role',
							'value' => 'ucfirst($data->getUserRole($data->id))',
						),

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