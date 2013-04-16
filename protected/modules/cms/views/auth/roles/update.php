<h1>Update Role</h1>
<?php echo $this->renderPartial('roles/_form', array(
	'model'=>$model,
	'allOperations' => $allOperations,
	'item' => $item,
	'ancestors' => $ancestors,
	'descendants' => $descendants,
	'formModel' => $formModel,
	//'childOptions' => $childOptions,
	)); ?>  