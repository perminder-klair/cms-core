<div class="row-fluid">
	<h2 class="heading">Manage Tags</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-tags"></i>
              <h5>Blog Tags List</h5>
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
						array(
							'name'=>'name',
							'value'=>'CHtml::link($data->name, array("blog/index", "tag"=>$data->name), array("target"=>"_blank"));',
							'header'=>'Tag Name',
							'type'=>'raw',
						),
						'frequency'
					),
				)); ?>
            </div>
	</div>
</div>