<?php

class CmsPage extends CmsActiveRecord
{
	const TYPE_CMS=1;
	const TYPE_NON_CMS=2;
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className the class name
	 * @return CmsNode the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
    	return 'cms_page';
    }

    /**
     * @return array validation rules for model attributes
     */
    public function rules()
    {
        return array(
        	array('name, heading, body, status', 'required'),
        	array('status', 'in', 'range'=>array(1,2,3)),
            array('id, parentId, status, deleted, type', 'numerical', 'integerOnly'=>true),
            array('layout', 'length', 'max'=>25),
            array('heading, name', 'length', 'max'=>70),
			array('metaDescription', 'length', 'max'=>160),
            array('updated, body, status, type, tags, layout', 'safe'),
            array('id, created, updated, parentId, name, deleted, type', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules
     */
    public function relations()
    {
        return array(
            'parent'=>array(self::BELONGS_TO, 'CmsPage', 'parentId'),
            'children'=>array(self::HAS_MANY, 'CmsPage', 'parentId'),
            'blocks'=>array(self::HAS_MANY, 'CmsBlocks', 'parentId'),
            'media'=>array(self::MANY_MANY, 'CmsMedia', 'cms_content_media(content_id, media_id)', 'condition' => 'type = "page"'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '#',
            'created' => Yii::t('CmsModule.core', 'Created'),
            'updated' => Yii::t('CmsModule.core', 'Updated'),
            'name' => Yii::t('CmsModule.core', 'Url'),
            'parentId' => Yii::t('CmsModule.core', 'Parent'),
            'layout' => 'Layout',
            'heading' => Yii::t('CmsModule.core', 'Title'),
            'body' => Yii::t('CmsModule.core', 'Body'),
            'metaDescription' => Yii::t('CmsModule.core', 'Short Description'),
            'tags' => Yii::t('CmsModule.core', 'Tags'),
            'status' => 'Status',
            'type' => 'Type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('heading',$this->heading,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('parentId',$this->updated);

        return new CActiveDataProvider($this, array(
        	'criteria'=>$criteria,
        ));
    }
    
	public function scopes()
    {
        return array(
            'published'=>array(
            	'order'=>'created DESC',
            	'condition'=>'status = '.self::STATUS_PUBLISHED,
            ),
        );
    }

    /**
     * Returns the parent select options formatted as a tree.
     * @return array the options
     */
    public function getParentOptionTree()
    {
        $pages = CmsPage::model()->findAll();

        if (!$this->isNewRecord)
        { 
            $children = $this->getChildren($pages, true);
            $exclude = CMap::mergeArray(array($this->id), array_keys($children));
            $nodes = CmsPage::model()->findAll('id NOT IN (:exclude)', array(':exclude'=>implode(',', $exclude)));
        }

        $tree = $this->getTree($pages);

        $options = array('0' => Yii::t('CmsModule.core', 'No parent'));
        foreach ($tree as $branch)
        	$options = CMap::mergeArray($options, $this->getParentOptionBranch($branch));

        return $options;
    }

    /**
     * Returns a single branch of the parent select option tree.
     * @param array $branch the branch
     * @param int $depth the depth of the branch
     * @return array the options
     */
    protected function getParentOptionBranch($branch, $depth = 0)
    {
        $options = array();

        $options[$branch['model']->id] = str_repeat('...', $depth + 1).' '.$branch['model']->name;

        if (!empty($branch['children']))
        	foreach ($branch['children'] as $leaf)
            	$options = CMap::mergeArray($options, $this->getParentOptionBranch($leaf, $depth + 1));

        return $options;
    }

    /**
     * Returns the given pages as a tree.
     * @param CmsPage[] $nodes the page to process
     * @param bool $includeOrphans indicated whether to include nodes which parent has been deleted.
     * @return array the tree
     */
    public function getTree($pages, $includeOrphans = false)
    {
        $tree = $this->getBranch($pages);

        // Get the orphan nodes as well (i.e. those which parent has been deleted) if necessary.
        if ($includeOrphans)
        	foreach($pages as $page)
            	$tree[$page->id] = array('model'=>$page, 'children'=>$this->getBranch($pages, $page->id));

        return $tree;
    }

    /**
     * Returns the given pages as a branch.
     * @param CmsPage[]$nodes the nodes to process
     * @param int $parentId the parent id
     * @return array the branch
     */
    protected function getBranch(&$nodes, $parentId = 0)
    {
        $children = array();
        /** @var CmsPage $node */
        foreach ($nodes as $idx => $node)
        {
            if ((int) $node->parentId === (int) $parentId)
            {
                $children[$node->id] = array('model'=>$node, 'children'=>$this->getBranch($nodes, $node->id));
                unset($nodes[$idx]);
            }
        }

        return $children;
    }

    /**
     * Returns the children for this page.
     * @param CmsPage[] $nodes the nodes to process
     * @param bool $recursive indicates whether to include grandchildren
     * @return CmsPage[] the children
     */
    protected function getChildren(&$nodes, $recursive = false)
    {
        $children = array();

        /** @var CmsPage $node */
        foreach ($nodes as $idx => $node)
        {
            if ((int) $node->parentId === (int) $this->id)
            {
                $children[$node->id] = $node;
                unset($nodes[$idx]);

                if ($recursive)
                	$children = CMap::mergeArray($children, $node->getChildren($nodes, $recursive));
            }
        }

        return $children;
    }

    /**
     * Renders the page tree.
     */
    public function renderTree()
    {
    	$criteria = new CDbCriteria(); 

    	if(isset($_GET['CmsPage']))
			$criteria->addSearchCondition('heading',$_GET['CmsPage']['heading']);
			
        $pages = CmsPage::model()->findAll($criteria);
        $tree = $this->getTree($pages, true);

        //echo CHtml::openTag('div', array('class'=>'page-tree'));
        //echo CHtml::openTag('ul', array('class'=>'root'));
        if(count($pages)<=0) {
	        echo 'No pages to display.';
        } else {
        	foreach ($tree as $branch)
        		$this->renderBranch($branch);
        }

        //echo '</ul>';
        //echo '</div>';
    }

    /**
     * Renders a single branch in the page tree.
     * @param array $branch the branch
     */
    protected function renderBranch($branch)
    {
    	//$model = $branch['model'];
        echo '<li class="'.$branch["model"]->getPriorityClass().'" style="height: 50px;">';
        //echo CHtml::link($branch['model']->name, array('node/update','id'=>$branch['model']->id));
        echo '<a href="'.url('/cms/pages/update', array('id'=>$branch["model"]->id)).'">';
        
        	echo '<div class="content">';
	        	echo '<h5>'.$branch["model"]->heading.' ('.$branch["model"]->name.')</h5>';
	        	if($branch["model"]->status==self::TYPE_NON_CMS) echo '<span>'.CmsLookup::item("PageStatus", $branch["model"]->status).' - </span>';
	        	echo '<span><em>'.CmsLookup::item("PageType", $branch["model"]->type).'</em></span>';
	        echo '</div>';
	        echo '<ul class="rightboxes">';
	        	echo '<li style="width: 100%;">'.$branch["model"]->adminActions().'</li>';
	        echo '</ul>';
	        
	        
	    echo '</a>';
        echo '</li>';
        
        if (!empty($branch['children']))
        {
            echo CHtml::openTag('ul', array('style'=>'margin-left:20px;'));

            foreach ($branch['children'] as $leaf)
            	$this->renderBranch($leaf);

            echo '</ul>';
        }
    }

    /**
     * Creates content for this node.
     * @param string $locale the locale id, e.g. 'en_us'
     * @return CmsContent the content model
     */
    public function createContent($locale)
    {
        $content = new CmsContent();
        $content->nodeId = $this->id;
        $content->locale = $locale;
        $content->save();
        return $content;
    }

    /**
     * Returns the breadcrumb text for this page.
     * @param boolean $link indicates whether to return the breadcrumb as a link
     * @return string the breadcrumb text
     */
    public function getBreadcrumbs($link = false)
    {
        $breadcrumbs = array();

        if ($this->parent !== null)
        	$breadcrumbs = $this->parent->getBreadcrumbs(true); // get the parent as a link
        else
        {
            // Do not include the module breadcrumbs for pages.
            if (Yii::app()->controller->route !== 'cms/pages/view')
            {
                $breadcrumbs[Yii::t('CmsModule.core','Cms')] = array('admin/index');
                $breadcrumbs[Yii::t('CmsModule.core','Pages')] = array('pages/index');
            }
        }

        if (!empty($this->breadcrumb))
        	$text = $this->breadcrumb;
        else
        	$text = ucfirst($this->name);

        if ($link)
        	$breadcrumbs[$text] = $this->getUrl();
        else
        	$breadcrumbs[] = $text;

        return $breadcrumbs;
    }

    /**
     * Returns the URL for this page.
     * @param array $params additional GET parameters (name=>value)
     * @return string the URL
     */
    public function getUrl($params = array())
    {
    	return url('/cms/pages/view/', array('id'=>$this->id, 'name'=>$this->getContentUrl()));
    }

    /**
     * Returns the SEO optimized name of this page.
     * @return string the name
     */
    public function getContentUrl()
    {
        $url = ucfirst($this->name);

        return $url;
    }

    /**
     * Returns the heading for this page.
     * @return string the heading
     */
    public function getHeading()
    {
        if (!empty($this->heading))
        	$heading = $this->heading;
        else
        	$heading = ucfirst($this->name);

        return $heading;
    }

    /**
     * Returns the body for this page.
     * @return string the body
     */
    public function getBody()
    {
        if (!empty($this->body))
            $body = $this->body;
        else
            $body = '';

        return $body;
    }

    /**
     * Returns the page title for this node.
     * @return string the page title
     */
    public function getPageTitle()
    {
        if (!empty($this->pageTitle))
        	$pageTitle = $this->pageTitle;
        else
        	$pageTitle = ucfirst($this->name);

        return $pageTitle;
    }

    /**
     * Renders this page.
     * @return string the rendered page
     */
    public function render()
    {
    	return Yii::app()->cms->renderer->render($this);
    }

    /**
     * Returns the HTMLPurifier instance for this content.
     * @return CHtmlPurifier the purifier
     */
    protected function getPurifier()
    {
        $purifier = new CHtmlPurifier();
        $purifier->options = CMap::mergeArray(Yii::app()->cms->htmlPurifierOptions, array(
                'Attr.EnableID'=>true, // we need to enable the id attribute
        ));
        return $purifier;
    }
        
    protected function afterFind()
    {
        $this->updated = date("d/m/Y", strtotime($this->updated));
        
        parent::afterFind();
    }
        
    public function beforeSave() {
	    $this->name = strtolower(preg_replace("/[^A-Za-z0-9]/", "-", $this->name));
	    	
	    return parent::beforeSave();
	}
		
    public function adminActions()
    {
    	$result = l('Edit',array('/cms/pages/update', 'id'=>$this->id), array('class'=>'btn btn-small btn-primary'));
    	if($this->type==1) $result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-small delete_dialog', 'data-url'=>url("/cms/pages/delete",array('id'=>$this->id))));
    	else $result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-small disabled'));
    	
    	return $result;
    }
    
    public function getPriorityClass()
    {
    	if($this->type==self::TYPE_CMS) {
		    if($this->status==self::STATUS_DRAFT)
		    	return 'priority-medium-left';
		    elseif($this->status==self::STATUS_PUBLISHED)
		    	return 'priority-low-left';
		    elseif($this->status==self::STATUS_ARCHIVED)
		    	return 'priority-high-left';
	    } else {
		    return 'priority-low-left';
	    }
    }
        
    public function isCmsPage() 
    {
        if($this->type==self::TYPE_CMS)
        	return true;
        else
        	return false;
    }	
    
    /*
     * Creates items list for menu
     * use it as: 'items'=>CmsPage::createChildernMenu('services'),
     */
    public function createChildernMenu($page)
    {
		$page = CmsPage::model()->findByAttributes(array('name'=>$page));
		
		$array = array();
		if($page)
			foreach($page->children as $child)
				$array[] = array('label'=>$child->heading, 'url'=>$child->getUrl());
		
		return $array; 
    }
    
    /**
     * Returns media in array
     * $rowCount=$command->execute();   // execute the non-query SQL
     * $dataReader=$command->query();   // execute a query SQL
     * $rows=$command->queryAll();      // query and return all rows of result
     * $row=$command->queryRow();       // query and return the first row of result
     * $column=$command->queryColumn(); // query and return the first column of result
     * $value=$command->queryScalar();  // query and return the first field in the first 
     * Usage:
	 * if($media = $data->mediaType(CmsMedia::TYPE_OTHER)) {
	 * 	$image=CmsMedia::getMedia($media['id']);
	 *	dump($image->render());
	 * }
     */
    public function mediaType($type, $count=null)
    {
    	$sql = "SELECT md.* FROM cms_content_media AS cm, cms_media as md";
    	$sql .= " WHERE cm.media_id=md.id";
    	$sql .= " AND cm.type='page'";
    	$sql .= " AND cm.content_id=".$this->id;
    	$sql .= " AND md.media_type=".$type;
    	
	    $result = Yii::app()->db->createCommand($sql);
	    
	    if($count=='all')
	    	return $result->queryAll();
	    else {
	    	$row = $result->queryRow();
	    	return CmsMedia::model()->findByPk($row['id']);
	    }
    }

}