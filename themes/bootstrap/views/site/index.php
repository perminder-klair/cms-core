<?php
$this->pageTitle='Home';
//$this->pageDescription='';
//$this->pageKeywords='';
//$this->pageAuthor='';
$this->pageOgTitle = 'my title';
$this->pageOgDesc = 'my title';
$this->pageOgImage = 'my title';
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.gl('site_name'),
)); ?>

<p>Congratulations! You have successfully created your Yii application.</p>

<?php $this->endWidget(); ?>

<p>You may change the content of this page by modifying the following two files:</p>

<ul>
    <li>View file: <code><?php echo __FILE__; ?></code></li>
    <li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
    the <a href="http://www.yiiframework.com/doc/">documentation</a>.
    Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
    should you have any questions.</p>
    
<p>For bootstrap docs read <a href="http://www.cniska.net/yii-bootstrap/">Yii-Bootstrap Docs</a> and official bootstrap <a href="http://twitter.github.com/bootstrap/">documentation</a>, also read here for more <a href="http://yii-booster.clevertech.biz/index.html">resources</a></p>