<ul>
	<? foreach($categories as $category): ?>
		<li><a href="<?=url('cms/blog/index', array('id'=>$category['id'], 'category'=>$category['url']));?>"><?=$category['title'];?></a>(<?=$category['category_count'];?>)</li>
	<? endforeach; ?>
</ul>