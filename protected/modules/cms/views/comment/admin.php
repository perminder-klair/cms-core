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
  <div class="widget-header-under"><?=$count;?> total comment(s) - <?=$model->getPendingCommentCount();?> Pending</div>
  <div class="widget-body">
    <div class="widget-tickets widget-tickets-large clearfix">
      <ul>
      	<? foreach($dataProvider as $comment): ?>
        <li class="<?=$comment->getPriorityClass();?>" id="comment-<?=$comment->id;?>">
          <h5>For Blog: <a href="<?=$comment->blog->getUrl();?>" style="display: inline;"><?=$comment->blog->title;?></a></h5>
           "<?=$comment->content;?>"
          <div class="date"><?=$comment->created;?></div>
          <div class="username"><?=$comment->author;?></div>
          <div class="settings"><a href="#"><i class="icon-ok"></i></a><a href="#"><i class="icon-reply"></i></a><a href="<?=url('/cms/comment/update/'.$comment->id);?>"><i class="icon-edit"></i></a><a class="delete_dialog" data-url="<?=url('/cms/comment/delete/'.$comment->id);?>" style="cursor:pointer;"><i class="icon-trash"></i></a></div>
        </li>
        <? endforeach; ?>
      </ul>
    </div>
  </div><!--/widget-body-->
</div> <!-- /widget span8 -->
</div> <!-- /row-fluid -->