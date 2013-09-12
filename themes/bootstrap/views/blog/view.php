<?php
$this->breadcrumbs=array(
	'Blogs'=>array('index'),
	$model->title,
);
?>

<?php $this->renderPartial('//blog/_view', array(
	'data'=>$model,
)); ?>


<div class="row-fluid">
	<div class="span12">
	
		<?php if($model->commentCount>=1): ?>
			<h3>
				<?php echo $model->commentCount>1 ? $model->commentCount . ' comments' : 'One comment'; ?>
			</h3>
	
			<?php $this->renderPartial('//blog/_comments',array(
				'post'=>$model,
				'comments'=>$model->comments,
			)); ?>
		<?php endif; ?>
	
		<h3>Leave a Comment</h3>
	
		<?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
			<div class="flash-success">
				<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
			</div>
		<?php else: ?>
			<?php $this->renderPartial('//blog/_commentForm',array(
				'model'=>$comment,
			)); ?>
		<?php endif; ?>

	</div>
</div>