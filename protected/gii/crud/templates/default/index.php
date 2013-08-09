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

<?php echo "<?php foreach(\$dataProvider as \$data): ?>
	<? \$this->renderPartial('_view', array('data'=>\$data)); ?>
<?php endforeach; ?>"; ?>

<?php echo "<?php if(\$listCategories): ?>
	<h2>Categories</h2>
	<?php foreach(\$listCategories as \$category): ?>
	        <a href=\"<?php echo url('/".$this->pluralize($this->class2name($this->modelClass))."/index', array('category'=>\$category->url));?>\"><?=\$category->title; ?></a> /
	<?php endforeach; ?>
<?php endif; ?>"; ?>