<div class="post">
	<h1>
		<?php echo CHtml::link(CHtml::encode($data->title), $data->url); ?>
	</h1>
	<div class="author">
		posted by <?php echo $data->author->getName() . ' on ' . date('F j, Y',strtotime($data->created)); ?>
	</div>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?=$data->modified; ?>
	</div>
</div>
