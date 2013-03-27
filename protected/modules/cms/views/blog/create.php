<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'Blogs'=>array('index'),
	'Create',
);
?>

<h1>Create Blog</h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>