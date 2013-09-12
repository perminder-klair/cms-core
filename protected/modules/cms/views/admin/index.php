        <div class="row-fluid">
          <h2 class="heading">
                Dashboard
                <div class="btn-group pull-right">
                  <a class="btn" href="<?php echo $this->createAbsoluteUrl('/cms/admin/settings'); ?>"><i class="icon-cog"></i> Settings</a>
                </div>
          </h2>
        </div>

        <?php $this->widget('OoCharts', array(
            'apiKey'=>null,
            'appId'=>null,
        )); ?>

        <div class="row-fluid">
          <div class="widget span8">
            <div class="widget-header">
              <i class="icon-book"></i>
              <h5>Recent Published Blogs</h5>
              <div class="widget-buttons">
                  <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
              </div>
            </div>  
            <div class="widget-body" style="height:310px;overflow:hidden">
              <div class="widget-tickets clearfix slimscroll">
          		<?php if(count($blogs)<=0) { ?>
          			<h5>&nbsp;&nbsp;No blogs to display.</h5>
          		<?php } else { ?>
                <ul>
                	<?php foreach($blogs as $blog): ?>
	                  <li class="priority-low">
	                    <a href="<?php echo url("/cms/blog/update", array('id'=>$blog->id)); ?>" style="padding-left:10px;">
	                      <h5><?php echo $blog->title; ?></h5>
	                      <p>By: <?php echo $blog->author->username; ?></p>
	                      <div class="date"><?php echo $blog->modified; ?></div>
	                    </a>
	                  </li>
                  	<?php endforeach; ?>
                </ul>
                <?php } ?>
              </div>
            </div><!--/widget-body-->
            <div class="widget-footer">
              <a href="javascript:void(0)" class="pull-right btn btn-small"><i class="icon-plus"></i> Load More</a>
            </div>
          </div> <!-- /widget span5 -->

          <div class="widget span4">
            <div class="widget-header">
              <i class="icon-comment-alt"></i>
              <h5>Recent Comments</h5>
              <div class="widget-buttons">
                  <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
              </div>
            </div>  
            <div class="widget-body" style="height:310px;overflow:hidden">
              <div class="widget-comments clearfix slimscroll">
          		<?php if(count($comments)<=0) { ?>
          			<h5>&nbsp;&nbsp;No comments to display.</h5>
          		<?php } else { ?>
                <ul>
                	<?php foreach($comments as $comment): ?>
	                  <li>
	                    <div class="comment-bubble" style="margin: 15px 10px 20px;">
	                      <h4><?php echo $comment->author; ?> - <a href="<?php echo $comment->blog->getUrl(); ?>" style="display: inline;"><strong><?php echo $comment->blog->title; ?></strong></a></h4>
	                      <?php echo $comment->content; ?>
	                      <div class="date"><?php echo $comment->created; ?></div>
	                      <div class="settings">
	                        <a href="javascript:void(0)" class="tip" data-title="Reply"><i class="icon-reply"></i></a><a href="javascript:void(0)" class="tip" data-title="Delete"><i class="icon-trash"></i></a><a href="javascript:void(0)" class="tip" data-title="Edit"><i class="icon-edit"></i></a>
	                      </div>
	                    </div>
	                  </li>
                  	<?php endforeach; ?>
                </ul>
                <?php } ?>
              </div>
            </div><!--/widget-body-->
            <div class="widget-footer">
              <a href="javascript:void(0)" class="pull-right btn btn-small"><i class="icon-plus"></i> Load More</a>
            </div>
          </div> <!-- /widget span5 -->
        </div> <!-- /row-fluid -->