<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\LinkStaffSubject */
/* @var $form yii\widgets\ActiveForm */
$readonly = $readonly ? true : false;
if($model->isNewRecord){
    $dis=false;
}else{
    $dis=true;
}
?>

<div class="link-staff-subject-form">

    <?php $form = ActiveForm::begin(['options' => ['id' => 'link-form', 'class' => 'protected-form'], 'readonly' => $readonly]); ?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('user_id') ?>
        </label>
        <div class="col-sm-4">
            <?php
            $site = !empty($model->user_id) ? $model->user->fullName : NULL;
            echo $form->field($model, 'user_id')->widget(Select2::classname(), [
                'initValueText' => $site, #  set the initial display text,
                'options' => ['placeholder' => 'Type your keyword then choose from options...', 'id' => 'user_id'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 0,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['staff/get-user-list', 'limit' => 12]),
                        'dataType' => 'json',
                        'delay' => 500,
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function (site) { return site.text; }'),
                    'templateSelection' => new JsExpression('function (site) { return site.text; }'),
                    'disabled' => $dis
                ],
            ])->label(false);

            ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('subject_id') ?>
        </label>
        <div class="col-sm-4">
            <?php
            $site = !empty($model->subject_id) ? $model->subject->title : NULL;
            echo $form->field($model, 'subject_id')->widget(Select2::classname(), [
                'initValueText' => $site, #  set the initial display text,
                'options' => ['placeholder' => 'Type your keyword then choose from options...', 'id' => 'subject_id'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 0,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['staff/get-subject-list', 'limit' => 12]),
                        'dataType' => 'json',
                        'delay' => 500,
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function (site) { return site.text; }'),
                    'templateSelection' => new JsExpression('function (site) { return site.text; }'),
                    'disabled' => $dis
                ],
            ])->label(false);

            ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('day_id') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'day_id')->dropDownList(Yii::$app->params['day'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $dis])->label(false) ?>
        </div>
    </div>


    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_09_00_to_09_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_09_00_to_09_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_09_15_to_09_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_09_15_to_09_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_09_30_to_09_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_09_30_to_09_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_09_45_to_10_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_09_45_to_10_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_10_00_to_10_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_10_00_to_10_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_10_15_to_10_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_10_15_to_10_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_10_30_to_10_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_10_30_to_10_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_10_45_to_11_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_10_45_to_11_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_11_00_to_11_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_11_00_to_11_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_11_15_to_11_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_11_15_to_11_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_11_30_to_11_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_11_30_to_11_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_11_45_to_12_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_11_45_to_12_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_12_00_to_12_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_12_00_to_12_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_12_15_to_12_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_12_15_to_12_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_12_30_to_12_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_12_30_to_12_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_12_45_to_13_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_12_45_to_13_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_13_00_to_13_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_13_00_to_13_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_13_15_to_13_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_13_15_to_13_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_13_30_to_13_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_13_30_to_13_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_13_45_to_14_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_13_45_to_14_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_14_00_to_14_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_14_00_to_14_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_14_15_to_14_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_14_15_to_14_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_14_30_to_14_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_14_30_to_14_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_14_45_to_15_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_14_45_to_15_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_15_00_to_15_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_15_00_to_15_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_15_15_to_15_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_15_15_to_15_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_15_30_to_15_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_15_30_to_15_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_15_45_to_16_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_15_45_to_16_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_16_00_to_16_15') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_16_00_to_16_15')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_16_15_to_16_30') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_16_15_to_16_30')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_16_30_to_16_45') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_16_30_to_16_45')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('time_16_45_to_17_00') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'time_16_45_to_17_00')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">
            <?= $model->getAttributeLabel('is_active') ?>
        </label>
        <div class="col-sm-4">
            <?= $form->field($model, 'is_active')->dropDownList([0 => 'No',1 => 'Yes'],
                ['class' => 'form-control',
                    'style' => 'width: initial;', 'disabled' => $readonly])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
