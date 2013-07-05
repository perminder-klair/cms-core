<?php
/* @var $this DemoController */
/* @var $model Demo */

$this->breadcrumbs=array(
	'Demos'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Demo', 'url'=>array('index')),
	array('label'=>'Create Demo', 'url'=>array('create')),
	array('label'=>'Update Demo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Demo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Demo', 'url'=>array('admin')),
);
?>

<h1>View Demo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'description',
		'created',
		'updated',
		'listing_order',
		'active',
		'deleted',
	),
)); ?>
