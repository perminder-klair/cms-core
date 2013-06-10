<?php
/* @var $this PeopleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Peoples',
);

?>

<h1>Peoples</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
