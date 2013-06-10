<?php
/* @var $this DemoController */
/* @var $model Demo */

$this->breadcrumbs=array(
	'Demos'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Demo', 'url'=>array('index')),
	array('label'=>'Create Demo', 'url'=>array('create')),
	array('label'=>'View Demo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Demo', 'url'=>array('admin')),
);
?>

<h1>Update Demo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>