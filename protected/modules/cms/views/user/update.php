<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'User'=>array('index'),
	'Update',
);
?>

<h1>Update User <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>