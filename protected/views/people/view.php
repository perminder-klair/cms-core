<?php
/* @var $this PeopleController */
/* @var $model People */

$this->breadcrumbs=array(
	'Peoples'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List People', 'url'=>array('index')),
	array('label'=>'Create People', 'url'=>array('create')),
	array('label'=>'Update People', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete People', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage People', 'url'=>array('admin')),
);
?>

<h1>View People #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'created',
		'updated',
		'listing_order',
		'active',
		'deleted',
	),
)); ?>
