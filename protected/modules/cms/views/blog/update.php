<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'Blog'=>array('index'),
	'Update',
);
?>

<h1>Update Blog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>