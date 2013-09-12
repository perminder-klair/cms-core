<?php
/* @var $this FilmController */
/* @var $model Film */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Update',
);
?>

<h1>Update Page <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php if(!$model->isCmsPage()): ?>
	<?php $this->renderPartial('_blocks', array('model'=>$model)); ?>
<?php endif; ?>