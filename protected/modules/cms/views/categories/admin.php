<div class="row-fluid">
	<h2 class="heading">Manage Categories		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href='/cms/categories/create'"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-group"></i>
              <h5>Manage Categories</h5>
              <div class="widget-buttons">
                  <a href="#" data-title="Collapse" data-collapsed="false" class="tip collapse"><i class="icon-chevron-up"></i></a>
              </div>
            </div>  
            <div class="widget-body">
            	<!-- http://www.yiiframework.com/doc/api/1.1/CGridView#cssFile-detail -->
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'cms-categories-grid',
					'itemsCssClass'=>'table table-striped table-bordered dataTable',
					//'enablePagination'=>false,
					'ajaxUpdate' => false,
					'dataProvider'=>$model->search(),
					//'filter'=>$model,
					'cssFile'=>false,
					'columns'=>array(
						'title',
						array(
							'header'=>'Parent',
							'value'=>'CmsLookup::item("CategoryStatus", $data->parent);',
						),
						array(
							'header'=>'Type',
							'value'=>'CmsLookup::item("CategoryType", $data->category_type);',
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