<ul>
	<?php foreach($categories as $category): ?>
		<li><a href="<?php echo url('cms/blog/index', array('id'=>$category['id'], 'category'=>$category['url']));?>"><?=$category['title'];?></a>(<?=$category['category_count']; ?>)</li>
	<?php endforeach; ?>
</ul>