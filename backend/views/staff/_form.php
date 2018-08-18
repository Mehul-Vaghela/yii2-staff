<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Staff */
/* @var $form yii\widgets\ActiveForm */
$readonly = $readonly ? true : false;
if (!$model->isNewRecord) {
    $email_readonly=true;
}else{
    $email_readonly=false;
}
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'staff-form', 'class' => 'protected-form'], 'readonly' => $readonly]); ?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('firstname') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'readonly' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('lastname') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'readonly' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('username') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => $email_readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('email') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => $email_readonly])->label(false) ?>
        </div>
    </div>
    <?php
    if ($model->isNewRecord) {
        ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">
                <?= $model->getAttributeLabel('password') ?>
            </label>
            <div class="col-sm-4">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'readonly' => $readonly])->label(false) ?>
            </div>
        </div>
        <?php
    }

    if(!$readonly){
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        </div>
    <?php
    }
    ?>

    <?php ActiveForm::end(); ?>

</div>
