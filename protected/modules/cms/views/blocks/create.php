<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'Blocks'=>array('index'),
	'Create',
);
?>

<h1>Create Block</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>