<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle='Password Reset';
$this->breadcrumbs=array(
    'Password Reset',
);
?>

<h1>Password Reset</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">

    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'password-form',
        'type'=>'horizontal',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->passwordFieldRow($model,'password'); ?>

    <?php echo $form->passwordFieldRow($model,'password_repeat'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Submit',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->