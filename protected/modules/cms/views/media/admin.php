<div class="row-fluid">
	<h2 class="heading">Manage Media
		<div class="btn-group pull-right">

	    </div>
	</h2>
</div>

<div class="row-fluid">
    <div class="span12">
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
            'id' => 'media',
            'config' => array(
                'request' => array(
                    'endpoint' => '/cms/media/upload',
                    'params' => array('index' => 'value'),
                ),
                'validation' => array(
                    'allowedExtensions' => CmsMedia::allowedFileTypes(),
                    'sizeLimit' => CmsMedia::FILE_SIZE_LIMIT, // max file size in bytes
                    'minSizeLimit' => 256, // min file size in bytes
                ),
                'callbacks' => array(
                    'onComplete' => 'js:function(id, fileName, responseJSON){
                         //console.log(responseJSON);
                         if (responseJSON.success) {
                            window.location.reload(false);
                         }
                    }',
                ),
            )
        )); ?>
    </div>
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