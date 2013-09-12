<div class="hero-unit">
	<h1><?php echo CHtml::link(CHtml::encode($data->title), $data->getUrl()); ?></h1>
	<p>
        <?php
        if($data->author->authorImage()){
            $this->widget('ext.yii-gravatar.YiiGravatar', array(
                'email'=>$data->author->email,
                'size'=>40,
                'defaultImage'=>$data->author->authorImage(),
                'secure'=>false,
                'rating'=>'r',
                'emailHashed'=>false,
                'htmlOptions'=>array(
                    'alt'=>$data->author->getName().' Gravatar image',
                    'title'=>$data->author->getName().' Gravatar image',
                )
            ));
        } ?>
        <small>posted by <?php echo $data->author->getName() . ' on ' . date('F j, Y',strtotime($data->created)); ?></small>
    </p>
	<p>
        <?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
    </p>
    <p>
        <h2>Media</h2>
        <?php if($media = $data->mediaType(CmsMedia::TYPE_FEATURED)) {
            $image=CmsMedia::getMedia($media['id']);
            dump($image->render());
        } ?>
    </p>
	<p>
		<b>Tags:</b>
		<?php echo implode(', ', $data->tagLinks); ?>
		<br/>
		<?php echo CHtml::link('Permalink', $data->url); ?> |
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo $data->modified; ?>
    </p>
</div>