<?php
/* @var $this BlogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Blogs',
);
?>

<h1>Blogs <small>(<?=l('RSS Feed',array('/cms/blog/feed'));?>)</small></h1>

 <?
 	$this->widget('TagCloud');
 ?>

<? foreach($dataProvider as $blog): ?>
	<a href="<?=$blog->getUrl();?>"><?=$blog->title;?></a><br />
	
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
<? endforeach; ?>

<?php $this->widget('CLinkPager', array(
    'pages' => $pages,
)) ?>