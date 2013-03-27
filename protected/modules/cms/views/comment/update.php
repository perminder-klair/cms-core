<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'Comment'=>array('index'),
	'Update',
);
?>

<h1>Update Comment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>