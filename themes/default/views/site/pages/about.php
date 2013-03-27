<?php
/* @var $this SiteController */

$this->pageTitle='About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>

<?php $this->widget('cms.widgets.CmsBlock',array('name'=>'bar')) ?>

<a href="<?php echo Yii::app()->cms->createUrl('foo'); ?>">page</a>