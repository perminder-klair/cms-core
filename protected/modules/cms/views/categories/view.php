<?php
/* @var $this CategoriesController */
/* @var $model CmsCategories */

$this->breadcrumbs=array(
	'Cms Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CmsCategories', 'url'=>array('index')),
	array('label'=>'Create CmsCategories', 'url'=>array('create')),
	array('label'=>'Update CmsCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CmsCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CmsCategories', 'url'=>array('admin')),
);
?>

<h1>View CmsCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'url',
		'parent',
	),
)); ?>
