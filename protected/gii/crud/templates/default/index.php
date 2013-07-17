<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>

?>

<h1><?php echo $label; ?></h1>

<?php echo "<? foreach(\$dataProvider as \$data): ?>
	<? \$this->renderPartial('_view', array('data'=>\$data)); ?>
<? endforeach; ?>"; ?>

<?php echo "<? if(\$listCategories): ?>
	<h2>Categories</h2>
	<? foreach(\$listCategories as \$category): ?>
	        <a href=\"<?=url('/".$this->pluralize($this->class2name($this->modelClass))."/index', array('category'=>\$category->url));?>\"><?=\$category->title;?></a> /
	<? endforeach; ?>
<? endif; ?>"; ?>