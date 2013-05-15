<?php

Yii::import('zii.widgets.CPortlet');

class BlogArchive extends CPortlet
{
	/**
	* Gets all posts ordered by create_time and sorts them by year and month.
	*
	* @return array posts sorted by year and month
	* @since 0.1
	*/
	protected function getEntries() {
		$criteria = new CDbCriteria;
		$criteria->order = 'date_start DESC';
		$entries = CmsBlog::model()->published()->findAll($criteria);
		$result = array();
		foreach($entries as $value) {
			$temp=array();
			$temp['year']=date('Y',strtotime($value->date_start));
			$temp['month']=date('m',strtotime($value->date_start));
			$result[$temp['year']][$temp['month']][] = array('title'=>($value->title),'url'=>$value->getUrl());
		}
		return $result;
	}

	protected function renderContent()
	{
		$this->render('blogArchive', array(
			'data'=>$this->getEntries(),
		));
	}
}