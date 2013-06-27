<div class="row-fluid">
	<h2 class="heading">Manage Media
		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href=''"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-picture"></i>
              <h5>Manage Media</h5>
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
							'name'=>'filename',
							'value'=>'CHtml::link($data->filename, array("/".$data->source), array("rel"=>"facybox"));',
							'header'=>'Page Name',
							'type'=>'raw',
						),
						'mimeType',
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