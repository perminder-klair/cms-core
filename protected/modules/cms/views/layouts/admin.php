<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <?php 
    	$this->pageTitle='BroomeCMS';
	    $this->pageDescription='BroomeCMS based on Yii Framework';
	    $this->pageKeywords='BroomeCMS, seo cms, php cms, yii cms';
	    $this->pageAuthor='TBL Marketing';
    ?>
    <?php $this->getMetaData(); ?>
    
    <?php Yii::app()->setting->getAdminScripts(); ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=Yii::app()->cms->assetsUrl;?>/ico/favicon.png">
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
            <img src="<?=Yii::app()->cms->assetsUrl;?>/img/logo.png" alt="Realm Admin Template">
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
              <li><a id="" href="<?=$this->createAbsoluteUrl('/cms/admin/settings')?>"><i class="icon-cogs"></i> Site Settings</a></li>
              <!--<li><a id="notifications" data-notification="0" href="#"><i class="icon-globe"></i> Notifications</a></li>-->
            </ul>
            <ul class="pull-right">  
              <li><a href="<?=$this->createAbsoluteUrl('/cms/admin/logout')?>"><i class="icon-off"></i> Logout</a></li>
            </ul>
          </div>

          <div class="top-menu visible-phone visible-tablet">
            <ul class="pull-right">  
              <!--<li><a title="link to View all Messages page, no popover in phone view or tablet" href="#"><i class="icon-envelope"></i></a></li>
              <li><a title="link to View all Notifications page, no popover in phone view or tablet" href="#"><i class="icon-globe"></i></a></li>-->
              <li><a href="<?=$this->createAbsoluteUrl('/cms/admin/logout')?>"><i class="icon-off"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="sidebar-nav nav-collapse collapse">
        <div class="user_side clearfix">
          <img src="<?=Yii::app()->cms->assetsUrl;?>/img/tom.png" alt="Odinn god of Thunder">
          <h5><?=Yii::app()->user->name;?></h5>
          <a href="<?=url("/cms/user/update", array('id'=>userId()));?>"><i class="icon-cog"></i> Edit Profile</a>        
        </div>
        <div class="accordion" id="accordion2">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F79999 <?=$this->getId()=='admin'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/admin')?>"><i class="icon-dashboard"></i> <span>Dashboard</span></a>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_C3F7A7 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse1"><i class="icon-book"></i> <span>Blog</span></a>
            </div>
            <div id="collapse1" class="accordion-body collapse <?=$this->getId()=='blog'?'in':'';?><?=$this->getId()=='comment'?'in':'';?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <? if(($this->getAction()->getId()=='admin') && ($this->getId()=='blog')) { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/blog/admin')?>"><i class="icon-align-justify"></i> All Posts</a>
                <a class="accordion-toggle <?=$this->getAction()->getId()=='create'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/blog/create')?>"><i class="icon-plus-sign"></i> Add New</a>
                <a class="accordion-toggle  <? if(($this->getAction()->getId()=='admin') && ($this->getId()=='comment')) { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/comment/admin')?>"><i class="icon-comment"></i> Comments</a>
                <a class="accordion-toggle <?=$this->getAction()->getId()=='tags'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/blog/tags')?>"><i class="icon-tags"></i> Tags</a>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_9FDDF6 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse2"><i class="icon-picture"></i> <span>Media</span></a>
            </div>
            <div id="collapse2" class="accordion-body collapse <?=$this->getId()=='media'?'in':'';?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <?=$this->getAction()->getId()=='admin'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/media/admin')?>"><i class="icon-folder-open"></i> Library</a>
                <a class="accordion-toggle <?=$this->getAction()->getId()=='create'?'active':'';?>" href="#"><i class="icon-plus-sign"></i> Add New</a>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F6F1A2 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse3"><i class="icon-file-alt"></i> <span>Pages</span></a>
            </div>
            <div id="collapse3" class="accordion-body collapse <?=$this->getId()=='pages'?'in':'';?><?=$this->getId()=='blocks'?'in':'';?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <? if(($this->getAction()->getId()=='admin') && ($this->getId()=='pages')) { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/pages/admin')?>"><i class="icon-align-justify"></i> All Pages</a>
                <a class="accordion-toggle <?=$this->getAction()->getId()=='create'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/pages/create')?>"><i class="icon-plus-sign"></i> Add New Page</a>
                <a class="accordion-toggle <? if(($this->getAction()->getId()=='admin') && ($this->getId()=='blocks')) { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/blocks/admin')?>"><i class="icon-align-left"></i> All Text Blocks</a>
                <!--<a class="accordion-toggle <?=$this->getAction()->getId()=='create'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/blocks/create')?>"><i class="icon-plus-sign"></i> Add New</a>-->
              </div>
            </div>
          </div>
          <!--<div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F6F1A2" href="tasks.html"><i class="icon-tasks"></i> <span>Tasks</span></a>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_C1F8A9" href="analytics.html"><i class="icon-bar-chart"></i> <span>Analytics</span></a>
            </div>
          </div> 
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_9FDDF6" href="tickets.html"><i class="icon-bullhorn"></i> <span>Support Tickets</span></a>
            </div>
          </div>-->  
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F5C294 <?=$this->getId()=='categories'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/categories/admin')?>"><i class="icon-list"></i> <span>Categories</span></a>
            </div>
          </div>                 
          
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F6F1A2 collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse4"><i class="icon-user"></i> <span>Users</span></a>
            </div>
            <div id="collapse4" class="accordion-body collapse <?=$this->getId()=='user'?'in':'';?><?=$this->getId()=='auth'?'in':'';?>">
              <div class="accordion-inner">
                <a class="accordion-toggle <? if(($this->getAction()->getId()=='admin') && ($this->getId()=='user')) { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/user/admin')?>"><i class="icon-align-justify"></i> All Users</a>
                <a class="accordion-toggle <? if($this->getId()=='auth') { echo 'active'; } ?>" href="<?=$this->createAbsoluteUrl('/cms/auth/roles')?>"><i class="icon-group"></i> Manage Roles</a>
              </div>
            </div>
          </div>
          
          <!--<div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle b_F5C294 <?=$this->getId()=='user'?'active':'';?>" href="<?=$this->createAbsoluteUrl('/cms/user/admin')?>"><i class="icon-user"></i> <span>Users</span></a>
            </div>
          </div>-->
          
          <? if(count(Yii::app()->params['adminMenu'])>0) { ?>
	          <? foreach(Yii::app()->params['adminMenu'] as $key=>$value): ?>
	          <div class="accordion-group">
	            <div class="accordion-heading">
	              <a class="accordion-toggle b_F5C294 <?=$this->getId()==$value?'active':'';?>" href="<?=$this->createAbsoluteUrl('/'.$value.'/admin')?>"><i class="icon-align-justify"></i> <span><?=ucfirst($value);?></span></a>
	            </div>
	          </div> 
	          <? endforeach; ?>
          <? } ?>
          
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