<div class="row-fluid">
	<h2 class="heading">Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?>
		<div class="btn-group pull-right">
	        <button class="btn btn-primary" onclick="location.href='/<?php echo strtolower($this->modelClass);?>/create'"><i class="icon-plus"></i> Create New</button>
	    </div>
	</h2>
</div>

<div class="row-fluid">
	<div class="widget widget-padding span12">
		<div class="widget-header">
              <i class="icon-group"></i>
              <h5>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h5>
              <div class="widget-buttons">
                  <?php echo "<?php"; ?> $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'get',
				)); ?>

              		<div class="input-append">
              			<?php echo "<?php echo"; ?> $form->textField($model,'title',array('size'=>60,'maxlength'=>128, 'class'=>'select2-input', 'placeholder'=>'Search people')); ?>
              		</div>
              	<?php echo "<?php"; ?> $this->endWidget(); ?>
              </div>
            </div>  
            <div class="widget-body">
            	<!-- http://www.yiiframework.com/doc/api/1.1/CGridView#cssFile-detail -->
				<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
					'itemsCssClass'=>'table table-striped table-bordered dataTable',
					//'enablePagination'=>false,
					'ajaxUpdate' => false,
					'dataProvider'=>$model->search(),
					//'filter'=>$model,
					'cssFile'=>false,
					'columns'=>array(
				<?php
				$count=0;
				foreach($this->tableSchema->columns as $column)
				{
					if($column->name!='created' || $column->name!='active' || $column->name!='deleted'  || $column->name!='listing_order') {
						if(++$count==5)
							echo "\t\t/*\n";
						echo "\t\t'".$column->name."',\n";
					}
				}
				if($count>=5)
					echo "\t\t*/\n";
				?>
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