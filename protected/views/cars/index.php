<?php
/* @var $this CarsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cars',
);

?>

<h1>Cars</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
