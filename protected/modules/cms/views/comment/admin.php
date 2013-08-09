<div class="row-fluid">
<h2 class="heading">
  Blog Comments
</h2>
</div> <!-- /row-fluid -->
    
<div class="row-fluid">
<div class="widget span12">
  <div class="widget-header">
    <i class="icon-bullhorn"></i>
    <h5>Recent Comments</h5>
    <div class="widget-buttons">                    
      <a href="#" data-title="Collapse" data-collapsed="false" class="collapse"><i class="icon-chevron-up"></i></a>
    </div>
  </div>  
  <div class="widget-header-under"><?php echo $count; ?> total comment(s) - <?php echo $model->getPendingCommentCount(); ?> Pending</div>
  <div class="widget-body">
    <div class="widget-tickets widget-tickets-large clearfix">
      <ul>
      	<?php foreach($dataProvider as $comment): ?>
        <li class="<?php echo $comment->getPriorityClass(); ?>" id="comment-<?php echo $comment->id; ?>">
          <h5>For Blog: <a href="<?php echo $comment->blog->getUrl(); ?>" style="display: inline;"><?php echo $comment->blog->title; ?></a></h5>
           "<?php echo $comment->content; ?>"
          <div class="date"><?php echo $comment->created; ?></div>
          <div class="username"><?php echo $comment->author; ?></div>
          <div class="settings">
              <a href="#"><i class="icon-ok"></i></a>
              <a href="#"><i class="icon-reply"></i></a>
              <a href="<?php echo url('/cms/comment/update/'.$comment->id); ?>"><i class="icon-edit"></i></a>
              <a class="delete_dialog" data-url="<?php echo url('/cms/comment/delete/'.$comment->id); ?>" style="cursor:pointer;"><i class="icon-trash"></i></a>
          </div>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div><!--/widget-body-->
</div> <!-- /widget span8 -->
</div> <!-- /row-fluid -->