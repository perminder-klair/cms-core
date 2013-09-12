<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php $this->getMetaData(); ?>
	<?php Yii::app()->setting->loadJs(array('application')); ?>
	<?php Yii::app()->setting->loadCss(array('main', 'form')); ?>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo baseUrl(); ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo baseUrl(); ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo baseUrl(); ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
</head>

<body>

<div class="container <?php $this->bodyClass(); ?>" id="page">

	<div id="header">
		<div id="logo"><?php echo gl('site_name'); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Blog', 'url'=>array('/cms/blog/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/account/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/account/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	
	<div id="content">
		<?php if (isset($this->breadcrumbs)): ?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif?>

        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <?php echo Yii::app()->user->getFlash('success'); ?>
        <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('error')): ?>
            <?php echo Yii::app()->user->getFlash('error'); ?>
        <?php endif; ?>

		<?php echo $content; ?>
	</div>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo gl('site_name'); ?>.
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
