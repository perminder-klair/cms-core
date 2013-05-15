<?php foreach($data as $key=>$value):?>
	<h5 class="archiveTrigger"><a href="#"><span class="rightArrow">&#8250;</span> <?=CHtml::encode($key)?></a></h5>
	<ul class="archiveDates">
		<?php foreach($data[$key] as $key2=>$value2):?>
			<li><a href="<?=url('/cms/blog/index', array('archive'=>'true', 'month'=>$key2, 'year'=>$key));?>"><?=date("F", strtotime("2011-".$key2."-01"));?> <?=$key;?></a></li>
		<? endforeach; ?>
	</ul>
<?php endforeach;?>