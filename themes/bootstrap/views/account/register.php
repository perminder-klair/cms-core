<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle='Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<p>Please fill out the following form with your credentials:</p>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'register-form',
        'type'=>'horizontal',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'username'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->passwordFieldRow($model,'new_password'); ?>

    <?php echo $form->passwordFieldRow($model,'new_password_repeat'); ?>

    <?php echo $form->textFieldRow($model,'firstname'); ?>

    <?php echo $form->textFieldRow($model,'lastname'); ?>

    <?php echo $form->textFieldRow($model,'address'); ?>

    <?php echo $form->textFieldRow($model,'postcode'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Register',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->