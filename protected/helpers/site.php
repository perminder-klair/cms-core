<?php
	
	/**
	 * Converts to money format
	 */
	function yii_money_format($amount) {
		setlocale(LC_MONETARY, 'en_GB.UTF-8');
		return money_format('%n', $amount);
	}
	
	/**
	 * delete directory recursivly
	 */
	function deleteDirectory($dir, $keepDir=false) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
			if (!deleteDirectory($dir.DIRECTORY_SEPARATOR.$item)) return false;
		}
		if($keepDir)
			return true;
		else
			return rmdir($dir);
	}
	
	/**
	* merges new Get into current url
	* use it as: url("/model/action", mergeGet('limit', '50'));
	*/
	function mergeGet($key, $value) {
		if (array_key_exists($key, $_GET)) {
			$_GET[$key]=$value;
		}
		$array = array_merge(array($key => $value), $_GET);
		
		return $array;
	}