<?php
/* @var $this DemoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Demos',
);

?>

<h1>Demos</h1>

<?php foreach($dataProvider as $data): ?>
	<?php $this->renderPartial('_view', array('data'=>$data)); ?>
<?php endforeach; ?>
<?php if($listCategories): ?>
	<h2>Categories</h2>
	<?php foreach($listCategories as $category): ?>
	        <a href="<?php echo url('/Demos/index', array('category'=>$category->url)); ?>"><?php echo $category->title; ?></a> /
	<?php endforeach; ?>
<?php endif; ?>