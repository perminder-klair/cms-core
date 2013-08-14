<div class="row-fluid">
	<h2 class="heading">Manage Rules
		<div class="btn-group pull-right">
			<button class="btn btn-primary" onclick="location.href='roles'"><i class="icon-group"></i> Manage Roles</button>
	        <button class="btn btn-primary" onclick="location.href='createOperation'"><i class="icon-plus"></i> Create Rule</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-group"></i>
              <h5>Manage Rules</h5>
              <div class="widget-buttons">
              	<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			
              		</div>
              	<?php $this->endWidget(); ?>
              </div>
            </div>  
            <div class="widget-body">
				<div class="row-fluid">
                  <div class="span12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Role Name</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php foreach($roles as $key=>$value): ?>
                        <tr>
                          <td><?php echo $value; ?></td>
                          <td><?php echo l('Edit',array('/cms/auth/updateOperation', 'name'=>$key), array('class'=>'btn btn-mini btn-primary')); ?></td>
                          <td><?php echo l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/auth/deleteOperation",array('name'=>$key)))); ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div> 
            </div>
	</div>
</div>