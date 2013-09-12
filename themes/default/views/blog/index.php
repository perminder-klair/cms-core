<?php
/* @var $this BlogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blogs',
);
?>

<h1>Blogs <small>(<?php echo l('RSS Feed',array('/cms/blog/feed')); ?>)</small></h1>

 <?php
 	$this->widget('TagCloud');
 ?>

<?php foreach($dataProvider as $blog): ?>
	<a href="<?php echo $blog->getUrl();?>"><?php echo $blog->title; ?></a><br />
	
	<?php $this->widget('ext.XReadMore.XReadMore', array(
         'model'=>$blog,
         'attribute'=>'content',
         'maxChar'=>90,
         'showLink'=>false,
         'linkUrl' => null,
         'stripTags'=>true,
         'linkText'=>'Read more...',
       ));
    ?>
    <hr />
<?php endforeach; ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)); ?>

<div id="categories">
	<?php $this->widget('BlogCategories'); ?>
</div>

<div id="archive">
	<?php $this->widget('BlogArchive'); ?>
</div>