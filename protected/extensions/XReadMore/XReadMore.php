<?php
/**
 * XReadMore
 * ---------
 * A widget to shorten html content to a certain length, and give a link to read
 * for the full text.
 *
 * ###Use
 * ####Simple case
 * In the view add:
 * ~~~
 * [php]
 *     <?php
 *     $this->widget('ext.XReadMore.XReadMore', array(
 *       'model'=>$data,
 *		 'attribute'=>'Content',
 *     ));
 *
 *     $this->widget('ext.XReadMore.XReadMore', array(
		 'showLink'=>false,
         'model'=>$data,
		 'attribute'=>'Content',
		 'maxChar'=>100,
       ));
 *     ?>
 * ~~~
 *
 * @version 1.2
 * @author Syakur Rahman bS.xx7_37@yahoo.com
 * @license New BSD License
 *
 * History:
 * 21/03/13 Add a public function so it could be called without a widget.
 */

class XReadMore extends CWidget
{
    /**
     * @var boolean Show link to go to full text page
	 * @since 1.0
     */
    public $showLink = true;

	/**
	 * @var string Character to seperate text & link
	 * @since 1.2
	 */
	public $separatorLink = "<br />";

	/**
	 * @var CModel the data model, if set use model->attribute for long text, defaults to null
	 * @since 1.1
	 */
	public $model = null;

	/**
	 * @var string the attribute
	 * @since 1.0
	 */
	public $attribute = null;

	/**
	 * @var string the long text, model proprty should be null to use this
	 * @since 1.0
	 */
	public $text = null;

	/**
	 * @var boolean determines whether to return plain text or html text
	 * @since 1.0
	 */
	public $stripTags = true;

	/**
	 * @var int the maximal count of character before it is truncated
	 * @since 1.0
	 */
	public $maxChar = 400;

	/**
	 * @var string the separator to use after maxChar is satisfied
	 * @since 1.0
	 */
	public $separator = " ";

    /** 
     * @var array link html options.
     * @since 1.0
     */
    public $linkHtmlOptions = array();

    /** 
     * @var string link label, default 'Read more...'.
     * @since 1.0
     */
    public $linkText = 'Read more...';

    /** 
     * @var string link url.
     * @since 1.0
     */
    public $linkUrl = null;

    /**
     * @var boolean if short version will be returned or echoed.
     * @since 1.0
     */
    public $return = false;

	/**
	 * Initialize the extension
	 */
	public function init()
    {    
		parent::init();
		$this->validate();

		if($this->linkUrl === null && $this->showLink)
			$this->linkUrl =  array(strtolower(get_class($this->model)) . "/view", "id"=>$this->model->primaryKey );
    }

	/**
	 * Main function to shorten the text.
	 * @param string $text The text to be shorten.
	 * @return string
	 *
	 */
	public function shorten($text)
	{
		$tmp = $text;

		if($this->model !== null)
		{
			$attribute = $this->attribute;
			$tmp = $this->model->$attribute;
		}

		if($this->stripTags)
			$tmp = trim(strip_tags($tmp));

		if(strlen($tmp)>$this->maxChar)
		{
			$tmp = substr($tmp, 0, stripos($tmp, $this->separator, $this->maxChar)) . "...";
		}

		if(!$this->stripTags)
		{
			$purifier = new CHtmlPurifier;
			$tmp = $purifier->purify($tmp);
		}

		if($this->showLink)
		{
			$tmp .=$this->separatorLink . CHtml::link($this->linkText, $this->linkUrl, $this->linkHtmlOptions);
		}
		
		return $tmp;
	}

	/**
	 * Executes as a widget
	 */
    public function run()
    {
		echo $this->shorten($this->text);
    }

	/**
	 * Validates the text given to the extension
	 * @throws CException
	 */
	private function validate()
	{
		if($this->model === null && $this->text === null)
			throw new CException("Either model or text needs to have a value.");
		if($this->model !== null)
		{
			if($this->attribute === null)
				throw new CException("Attribute has an invalid value.");
		}
		if($this->text !== null)
		{
			if($this->linkUrl === null && $this->showLink)
				throw new CException("LinkUrl has an invalid value.");
		}
	}
}
