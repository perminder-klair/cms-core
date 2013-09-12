<h4>Upload Media</h4>
<hr>
    <script>
    	var content_id = "<?php echo $model->id; ?>";
    	var type = "<?php echo $type; ?>";
    </script>
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
              <th>Type</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          	<?php $mediaView = 'application.modules.cms.views.media.newMedia'; ?>
          	<?php foreach($model->media as $media): ?>
          		<?php echo Yii::app()->controller->renderPartial($mediaView, array('media'=>$media)); ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div> 