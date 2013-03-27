<?php

/**
 * EAjaxUpload class file.
 * This extension is a wrapper of http://valums.com/ajax-upload/
 *
 * @author Vladimir Papaev <kosenka@gmail.com>
 * @author Ianaré Sévi
 * @version 1.0.0
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAjaxUpload file upload widget.
 */
class EAjaxUpload extends CWidget
{
	const VERSION = '3.3.0';

	public $id = 'fileUploader';
	public $params = array();
	public $config = array();
	public $css;

	public function run()
	{
		if (!$this->config['request']['endpoint']) {
			throw new CException('EAjaxUpload: config["request"]["endpoint"] cannot be empty.');
		}

		if (empty($this->config['validation']['allowedExtensions'])) {
			throw new CException('EAjaxUpload: config["validation"]["allowedExtensions"] cannot be empty.');
		}

		if (!$this->config['validation']['sizeLimit']) {
			throw new CException('EAjaxUpload: config["validation"]["sizeLimit"] cannot be empty.');
		}

		echo '<div id="' . $this->id . '"><noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div>';

		$assets = dirname(__FILE__) . '/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);

		$cs = Yii::app()->getClientScript();
		
		if (YII_DEBUG)
			$js = $baseUrl . '/jquery.fineuploader-' . self::VERSION . '.js';
		else
			$js = $baseUrl . '/jquery.fineuploader-' . self::VERSION . '.min.js';
		
		$cs->registerScriptFile($js, CClientScript::POS_END);

		$this->css = (!empty($this->css)) ? $this->css : $baseUrl . '/fineuploader-' . self::VERSION . '.css';
		$cs->registerCssFile($this->css);

		$params = array(
			'PHPSESSID' => Yii::app()->session->sessionID,
			'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
		);
		if (isset($this->config['request']['params'])) {
			$params = array_merge($params, $this->config['request']['params']);
		}
		unset($this->config['request']['params']);

		$configArray = array(
			'element' => "js:$('#{$this->id}')[0]",
			'request' => array(
				'paramsInBody' => false,
				'params' => $params,
			),
			'debug' => YII_DEBUG,
			'multiple' => false,
		);
		$config = CJavaScript::encode(CMap::mergeArray($configArray, $this->config));

		$script = "var qq_{$this->id} = new qq.FineUploader($config);";
		$cs->registerScript('FineUploader_' . $this->id, $script, CClientScript::POS_READY);
	}

}