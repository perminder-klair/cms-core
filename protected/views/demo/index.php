<?php
/* @var $this DemoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Demos',
);

?>

<h1>Demos</h1>

<? foreach($dataProvider as $data): ?>
	<? $this->renderPartial('_view', array('data'=>$data)); ?>
<? endforeach; ?>
<? if($listCategories): ?>
	<h2>Categories</h2>
	<? foreach($listCategories as $category): ?>
	        <a href="<?=url('/Demos/index', array('category'=>$category->url));?>"><?=$category->title;?></a> /
	<? endforeach; ?>
<? endif; ?>