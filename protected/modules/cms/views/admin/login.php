<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="span12">
  	<div class="row-fluid">
		<div class="widget container-narrow">
			<div class="widget-header">
				<i class="icon-user"></i>
				<h5>Log in to your account</h5>
			</div>  
			<div class="widget-body clearfix" style="padding:25px;">
      			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>
					<div class="control-group">
						<div class="controls">
							<?php echo $form->textField($model,'username', array('class'=>'btn-block','placeholder'=>'Username')); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<?php echo $form->passwordField($model,'password', array('class'=>'btn-block','placeholder'=>'Password')); ?>
						</div>
					</div>
					 <div class="control-group">
						<div class="controls clearfix">
							<label style="width:auto" class="checkbox pull-left">
								<?php echo $form->checkBox($model,'rememberMe'); ?> <?php echo $form->label($model,'rememberMe'); ?>
							</label>
							<a style="padding: 5px 0px 0px 5px;" href="#" class="pull-right">Forgot Password?</a>
						</div>
					</div>					
					<?php echo CHtml::submitButton('Sign in', array('class'=>'btn pull-right')); ?>
      			<?php $this->endWidget(); ?>
			</div>  
		</div>  
			<div style="text-align:center">
				<p>Neen an account? <a href="new_account.html">Create Account</a></p>
			</div>
	</div><!--/row-fluid-->
</div><!--/span10-->
