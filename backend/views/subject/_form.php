<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */
/* @var $form yii\widgets\ActiveForm */
$readonly = $readonly ? true : false;
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'subject-form', 'class' => 'protected-form'], 'readonly' => $readonly]); ?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('title') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'readonly' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('is_active') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'is_active')->dropDownList([1 => 'Yes', 0 => 'No'],
                ['class' => 'form-control', 'prompt' => 'Provide your answer...',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <hr />
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
