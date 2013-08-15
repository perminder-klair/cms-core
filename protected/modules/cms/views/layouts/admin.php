<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <?php 
    	$this->pageTitle=Yii::app()->cms->cmsName;//'TBL CMS';
	    $this->pageDescription=Yii::app()->cms->cmsName.' based on Yii Framework';
	    $this->pageKeywords=Yii::app()->cms->cmsName.' seo cms, php cms, yii cms';
	    $this->pageAuthor='Parminder Klair';
    ?>
    <?php $this->getMetaData(); ?>
    
    <?php Yii::app()->setting->getAdminScripts(); ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo Yii::app()->cms->assetsUrl; ?>/ico/favicon.png">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="wrap">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="logo"> 
            <img src="<?php echo Yii::app()->cms->assetsUrl.Yii::app()->cms->cmsLogo; ?>" alt="CMS Logo">
          </div>
           <a class="btn btn-navbar visible-phone" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
           <a class="btn btn-navbar slide_menu_left visible-tablet">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <div class="top-menu visible-desktop">
            <ul class="pull-left">
              <li><a id="" href="<?php echo $this->createAbsoluteUrl('/cms/admin/settings'); ?>"><i class="icon-cogs"></i> Site Settings</a></li>
            </ul>
            <ul class="pull-right">  
              <li><a href="<?php echo $this->createAbsoluteUrl('/cms/admin/logout'); ?>"><i class="icon-off"></i> Logout</a></li>
            </ul>
          </div>

          <div class="top-menu visible-phone visible-tablet">
            <ul class="pull-right">
              <li><a href="<?php echo $this->createAbsoluteUrl('/cms/admin/logout'); ?>"><i class="icon-off"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="sidebar-nav nav-collapse collapse">
        <div class="user_side clearfix">
          <?php echo Yii::app()->cms->userGravatar(); ?>
          <h5><?php echo Yii::app()->user->name; ?></h5>
          <a href="<?php echo url("/cms/user/update", array('id'=>userId())); ?>"><i class="icon-cog"></i> Edit Profile</a>
        </div>
        <div class="accordion" id="accordion2">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F79999 <?php echo $this->getId()=='admin'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/admin'); ?>"><i class="icon-dashboard"></i> <span>Dashboard</span></a>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_C3F7A7 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse1"><i class="icon-book"></i> <span>Blog</span></a>
            </div>
            <div id="collapse1" class="accordion-body collapse <?php echo $this->getId()=='blog'?'in':''; ?><?php echo $this->getId()=='comment'?'in':''; ?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <?php if(($this->getAction()->getId()=='admin') && ($this->getId()=='blog')) { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/blog/admin'); ?>"><i class="icon-align-justify"></i> All Posts</a>
                <a class="accordion-toggle <?php echo $this->getAction()->getId()=='create'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/blog/create'); ?>"><i class="icon-plus-sign"></i> Add New</a>
                <a class="accordion-toggle  <?php if(($this->getAction()->getId()=='admin') && ($this->getId()=='comment')) { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/comment/admin'); ?>"><i class="icon-comment"></i> Comments</a>
                <a class="accordion-toggle <?php echo $this->getAction()->getId()=='tags'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/blog/tags'); ?>"><i class="icon-tags"></i> Tags</a>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_9FDDF6 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse2"><i class="icon-picture"></i> <span>Media</span></a>
            </div>
            <div id="collapse2" class="accordion-body collapse <?php echo $this->getId()=='media'?'in':''; ?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <?php echo $this->getAction()->getId()=='admin'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/media/admin'); ?>"><i class="icon-folder-open"></i> Library</a>
                <a class="accordion-toggle <?php echo $this->getAction()->getId()=='create'?'active':''; ?>" href="#"><i class="icon-plus-sign"></i> Add New</a>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F6F1A2 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse3"><i class="icon-file-alt"></i> <span>Pages</span></a>
            </div>
            <div id="collapse3" class="accordion-body collapse <?php echo $this->getId()=='pages'?'in':''; ?><?php echo $this->getId()=='blocks'?'in':''; ?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <?php if(($this->getAction()->getId()=='admin') && ($this->getId()=='pages')) { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/pages/admin'); ?>"><i class="icon-align-justify"></i> All Pages</a>
                <a class="accordion-toggle <?php echo $this->getAction()->getId()=='create'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/pages/create'); ?>"><i class="icon-plus-sign"></i> Add New Page</a>
                <a class="accordion-toggle <?php if(($this->getAction()->getId()=='admin') && ($this->getId()=='blocks')) { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/blocks/admin'); ?>"><i class="icon-align-left"></i> All Text Blocks</a>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F5C294 <?php echo $this->getId()=='categories'?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/cms/categories/admin'); ?>"><i class="icon-list"></i> <span>Categories</span></a>
            </div>
          </div>                 
          
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F6F1A2 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse4"><i class="icon-user"></i> <span>Users</span></a>
            </div>
            <div id="collapse4" class="accordion-body collapse <?php echo $this->getId()=='user'?'in':''; ?><?php echo $this->getId()=='auth'?'in':''; ?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <?php if(($this->getAction()->getId()=='admin') && ($this->getId()=='user')) { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/user/admin'); ?>"><i class="icon-align-justify"></i> All Users</a>
                <a class="accordion-toggle <?php if($this->getId()=='auth') { echo 'active'; } ?>" href="<?php echo $this->createAbsoluteUrl('/cms/auth/roles')?>"><i class="icon-group"></i> Manage Roles</a>
              </div>
            </div>
          </div>

          <?php if(count(Yii::app()->params['adminMenu'])>0) { ?>
	          <?php foreach(Yii::app()->params['adminMenu'] as $key=>$value): ?>
	          <div class="accordion-group">
	            <div class="accordion-heading">
	              <a class="accordion-toggle b_F5C294 <?php echo $this->getId()==$value?'active':''; ?>" href="<?php echo $this->createAbsoluteUrl('/'.$value.'/admin'); ?>"><i class="icon-list-alt"></i> <span><?php echo ucfirst($value); ?></span></a>
	            </div>
	          </div> 
	          <?php endforeach; ?>
          <?php } ?>
          
        </div>
      </div>
      <!-- /Side menu -->

      <!-- Main window -->
      <div class="main_container" id="dashboard_page">
        
        <div class="row-fluid">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
			        'tagName'=>'ul', // will change the container to ul
			        'htmlOptions'=>array('class'=>'breadcrumb'),
			        'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>', // will generate the clickable breadcrumb links 
			        'inactiveLinkTemplate'=>'<li>{label}</li>', // will generate the current page url : <li>News</li>
			        'homeLink'=>'<li><a href="'.Yii::app()->homeUrl.'">Home</a></li>' // will generate your homeurl item : <li><a href="/dr/dr/public_html/">Home</a></li>
				)); ?><!-- breadcrumbs -->
			<?php endif?>
		</div>
			
        
        <?php echo $content; ?>

      </div>
      <!-- /Main window -->
      
    </div><!--/.fluid-container-->
    </div><!-- wrap ends-->
    
  </body>
</html>