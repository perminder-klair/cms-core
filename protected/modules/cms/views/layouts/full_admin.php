<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <?php $this->getMetaData(); ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bluth Company">
    <link rel="shortcut icon" href="<?php echo Yii::app()->cms->assetsUrl; ?>/ico/favicon.png">
    <link href="<?php echo Yii::app()->cms->assetsUrl; ?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->cms->assetsUrl; ?>/css/theme.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->cms->assetsUrl; ?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->cms->assetsUrl; ?>/css/alertify.css" rel="stylesheet">
    <link rel="Favicon Icon" href="favicon.ico">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="wrap">
    <div class="container-fluid">
      <div class="row-fluid">
      	<?php echo $content; ?>
      </div><!--/row-fluid-->
    </div><!--/.fluid-container-->
    </div><!-- wrap ends-->

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/bootstrap.js"></script>
    <script type="text/javascript" src='<?php echo Yii::app()->cms->assetsUrl; ?>/js/sparkline.js'></script>
    <script type="text/javascript" src='<?php echo Yii::app()->cms->assetsUrl; ?>/js/morris.min.js'></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.masonry.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.imagesloaded.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.facybox.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.elfinder.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/jquery.alertify.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->cms->assetsUrl; ?>/js/realm.js"></script>
  </body>
</html>
