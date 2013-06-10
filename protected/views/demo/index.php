<?php
/* @var $this DemoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Demos',
);

?>

<h1>Demos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
