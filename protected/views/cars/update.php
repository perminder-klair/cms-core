<?php
/* @var $this CarsController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'Cars'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cars', 'url'=>array('index')),
	array('label'=>'Create Cars', 'url'=>array('create')),
	array('label'=>'View Cars', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>Update Cars <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>