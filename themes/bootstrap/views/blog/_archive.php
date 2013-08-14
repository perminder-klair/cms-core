<?php foreach($data as $key=>$value): ?>
	<h5 class="archiveTrigger"><a href="#"><span class="rightArrow">&#8250;</span> <?php echo CHtml::encode($key)?></a></h5>
	<ul class="archiveDates">
		<?php foreach($data[$key] as $key2=>$value2): ?>
			<li><a href="<?php echo url('/cms/blog/index', array('archive'=>'true', 'month'=>$key2, 'year'=>$key));?>"><?php echo date("F", strtotime("2011-".$key2."-01")); ?> <?php echo $key; ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php endforeach;?>