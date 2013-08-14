<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle='Login';
$this->breadcrumbs=array(
    'Login',
);
?>

<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'login-form',
        'type'=>'horizontal',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'username'); ?>

    <?php echo $form->passwordFieldRow($model,'password'); ?>

    <?php echo $form->checkBoxRow($model, 'rememberMe', array('disabled'=>true)); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Login',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<p><a href="<?php echo url('/account/register'); ?>">Register here</a></p>
<p><a href="<?php echo url('/account/passwordReset'); ?>">Recover Password</a></p>