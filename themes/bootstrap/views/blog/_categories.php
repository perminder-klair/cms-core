<ul>
	<?php foreach($categories as $category): ?>
		<li><a href="<?php echo url('cms/blog/index', array('id'=>$category['id'], 'category'=>$category['url']));?>"><?php echo $category['title']; ?></a>(<?php echo $category['category_count']; ?>)</li>
	<?php endforeach; ?>
</ul>