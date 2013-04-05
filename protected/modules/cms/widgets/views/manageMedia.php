<h4>Upload Media</h4>
<hr>
    <script>
    	var content_id = "<?=$model->id?>";
    	var type = "<?=$type?>";
    </script>
    <? $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
	    'id' => 'media_' + content_id,
	    'config' => array(
	        'request' => array(
	            'endpoint' => '/cms/media/upload',
	            'params' => array('index' => 'value'),
	        ),
	        'validation' => array(
	            'allowedExtensions' => array('jpg', 'jpeg', 'png', 'bmp'),
	            'sizeLimit' => 1048576, // max file size in bytes
	            'minSizeLimit' => 256, // min file size in bytes
	        ),
	        'callbacks' => array(
	            'onComplete' => 'js:function(id, fileName, responseJSON){
	            	 //console.log(responseJSON);
	            	 if (responseJSON.success) {
	            	 	$.post("/cms/media/insertMedia?type=" + type + "&content_id=" + content_id, responseJSON, function(data) {
							$("#gallery-container > tbody").prepend(data);
						});
	            	 	
	            	 }
	            }',
	        ),
	    )
	)); ?>
    
     <div class="row-fluid">
      <div class="span12">
        <table class="table" id="gallery-container">
          <thead>
            <tr>
              <th>File Name</th>
              <th>Published</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<? foreach($model->media as $media): ?>
          		<?php $view = 'application.modules.cms.views.media.newMedia';
          		echo Yii::app()->controller->renderPartial($view, array('media'=>$media)); ?>
            <? endforeach; ?>
          </tbody>
        </table>
      </div>
    </div> 