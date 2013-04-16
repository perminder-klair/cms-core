<div class="row-fluid">
	<h2 class="heading">Manage Roles
		<div class="btn-group pull-right">
			<button class="btn btn-primary" onclick="location.href='operations'"><i class="icon-ok-sign"></i> Manage Rules</button>
	        <button class="btn btn-primary" onclick="location.href='createRole'"><i class="icon-plus"></i> Create Role</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-group"></i>
              <h5>Manage Roles</h5>
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
                      	<? foreach($roles as $key=>$value): ?>
                        <tr>
                          <td><?=$value;?></td>
                          <td><?=l('Edit',array('/cms/auth/updateRole', 'name'=>$key), array('class'=>'btn btn-mini btn-primary'));?></td>
                          <td><?=l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/cms/auth/deleteRole",array('name'=>$key))));?></td>
                        </tr>
                        <? endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div> 
            </div>
	</div>
</div>