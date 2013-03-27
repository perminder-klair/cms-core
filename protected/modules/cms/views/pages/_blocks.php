      <div class="row-fluid">
        <div class="widget widget-padding span12">
          <div class="widget-header">
            <i class="icon-align-left"></i>
            <h5>Text Blocks</h5>
            <div class="widget-buttons">
              <a class="btn btn-primary" href="<?=Yii::app()->createUrl('/cms/blocks/create', array('id' => $model->id));?>">Create block</a>
            </div>
          </div>  
          <div class="widget-body">
          
				<div class="row-fluid">
                  <div class="span12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Block Name</th>
                          <th>Last Updated</th>
                          <th>Published</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<? foreach($model->blocks as $block): ?>
                        <tr>
                          <td><?=$block->name;?></td>
                          <td><?=$block->updated;?></td>
                          <td><?=CmsLookup::item('BlockStatus', $block->published);?></td>
                          <td><?=$block->adminActions();?></td>
                        </tr>
                        <? endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div> 
               
             </div> <!-- /widget-body -->
          </div> <!-- /widget -->
        </div> <!-- /row-fluid -->