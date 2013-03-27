<?php

class CmsMediaManager extends CWidget
{
	public $model;
	public $type;
	
	public function run()
	{ 
		$this->render('manageMedia', array(
			'model'=>$this->model,
			'type'=>$this->type,
		));
	}
}