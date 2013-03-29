<?php foreach($comments as $comment): ?>
<div class="row-fluid" id="c<?php echo $comment->id; ?>">
	<div class="span8">
		<?php echo CHtml::link("#{$comment->id}", $comment->getUrl($post), array(
			'class'=>'cid',
			'title'=>'Permalink to this comment',
		)); ?>
	
		<div class="span6">
			<?php echo $comment->authorLink; ?> says:
		</div>
	
		<div class="span6">
			<?php echo $comment->created; ?>
		</div>
	
		<div class="span6">
			<?php echo nl2br(CHtml::encode($comment->content)); ?>
		</div>
	</div>

</div><!-- comment -->
<?php endforeach; ?>