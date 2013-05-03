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
	
	/**
	 * gets the data from a URL 
	 * Usage: $returned_content = get_data('http://davidwalsh.name');
	 * Alternatively, you can use the file_get_contents function remotely, but many hosts don't allow this.
	 */
	function get_data($url) {
		$ch = curl_init();
		$timeout = 5;
		//For your script we can also add a User Agent:
		$userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)";
		
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}