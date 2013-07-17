<?php
$this->pageTitle='Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<p>Please fill out the following form with your credentials:</p>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'register-form',
        'enableAjaxValidation'=>true,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'new_password'); ?>
        <?php echo $form->passwordField($model,'new_password'); ?>
        <?php echo $form->error($model,'new_password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'new_password_repeat'); ?>
        <?php echo $form->passwordField($model,'new_password_repeat'); ?>
        <?php echo $form->error($model,'new_password_repeat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'firstname'); ?>
        <?php echo $form->textField($model,'firstname'); ?>
        <?php echo $form->error($model,'firstname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'lastname'); ?>
        <?php echo $form->textField($model,'lastname'); ?>
        <?php echo $form->error($model,'lastname'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'address'); ?>
        <?php echo $form->textField($model,'address'); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'postcode'); ?>
        <?php echo $form->textField($model,'postcode'); ?>
        <?php echo $form->error($model,'postcode'); ?>
    </div>


    <div class="row submit">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
