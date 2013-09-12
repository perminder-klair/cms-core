<div class="row-fluid">
	<h2 class="heading">Manage Blogs
		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href='create'"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-book"></i>
              <h5>Manage Blog</h5>
              <div class="widget-buttons">
              	<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128, 'class'=>'select2-input', 'placeholder'=>'Search blog')); ?>
              		</div>
              	<?php $this->endWidget(); ?>
              </div>
            </div>  
            <div class="widget-body">
            	<!-- http://www.yiiframework.com/doc/api/1.1/CGridView#cssFile-detail -->
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'blog-grid',
					'itemsCssClass'=>'table table-striped table-bordered dataTable',
					//'enablePagination'=>false,
					'ajaxUpdate' => false,
					'dataProvider'=>$model->search(),
					//'filter'=>$model,
					'cssFile'=>false,
					'columns'=>array(
						array(
							'name'=>'title',
							'value'=>'CHtml::link($data->title, array("blog/update", "id"=>$data->id));',
							'header'=>'Title',
							'type'=>'raw',
						),
						array(
							'header'=>'Status',
							'value'=>'CmsLookup::item("PostStatus", $data->status);',
						),
						'modified',
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