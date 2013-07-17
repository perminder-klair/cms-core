<?php
/* @var $this BlogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blogs',
);
?>

<div class="page-header">
	<h1>Blogs <small>(<?=l('RSS Feed',array('/cms/blog/feed'));?>)</small></h1>
</div>

 <?
 	$this->widget('TagCloud');
 ?>

<? foreach($dataProvider as $blog): ?>

    <div class="hero-unit">
	    <h1><?=$blog->title;?></h1>
	    <p><?php $this->widget('ext.XReadMore.XReadMore', array(
	         'model'=>$blog,
	         'attribute'=>'content',
	         'maxChar'=>90,
	         'showLink'=>false,
	         'linkUrl' => null,
	         'stripTags'=>true,
	         'linkText'=>'Read more...',
	       ));
	    ?></p>
	    <p>
		    <a href="<?=$blog->getUrl();?>" class="btn btn-primary btn-large">Read more</a>
	    </p>
    </div>
    
<? endforeach; ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>

<div id="categories">
    <? $this->widget('BlogCategories'); ?>
</div>

<div id="archive">
    <? $this->widget('BlogArchive'); ?>
</div>