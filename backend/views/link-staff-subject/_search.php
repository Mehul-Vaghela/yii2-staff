<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LinkStaffSubjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="link-staff-subject-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'subject_id') ?>

    <?= $form->field($model, 'day_id') ?>

    <?= $form->field($model, 'time_09_00_to_09_15') ?>

    <?php // echo $form->field($model, 'time_09_15_to_09_30') ?>

    <?php // echo $form->field($model, 'time_09_30_to_09_45') ?>

    <?php // echo $form->field($model, 'time_09_45_to_10_00') ?>

    <?php // echo $form->field($model, 'time_10_00_to_10_15') ?>

    <?php // echo $form->field($model, 'time_10_15_to_10_30') ?>

    <?php // echo $form->field($model, 'time_10_30_to_10_45') ?>

    <?php // echo $form->field($model, 'time_10_45_to_11_00') ?>

    <?php // echo $form->field($model, 'time_11_00_to_11_15') ?>

    <?php // echo $form->field($model, 'time_11_15_to_11_30') ?>

    <?php // echo $form->field($model, 'time_11_30_to_11_45') ?>

    <?php // echo $form->field($model, 'time_11_45_to_12_00') ?>

    <?php // echo $form->field($model, 'time_12_00_to_12_15') ?>

    <?php // echo $form->field($model, 'time_12_15_to_12_30') ?>

    <?php // echo $form->field($model, 'time_12_30_to_12_45') ?>

    <?php // echo $form->field($model, 'time_12_45_to_13_00') ?>

    <?php // echo $form->field($model, 'time_13_00_to_13_15') ?>

    <?php // echo $form->field($model, 'time_13_15_to_13_30') ?>

    <?php // echo $form->field($model, 'time_13_30_to_13_45') ?>

    <?php // echo $form->field($model, 'time_13_45_to_14_00') ?>

    <?php // echo $form->field($model, 'time_14_00_to_14_15') ?>

    <?php // echo $form->field($model, 'time_14_15_to_14_30') ?>

    <?php // echo $form->field($model, 'time_14_30_to_14_45') ?>

    <?php // echo $form->field($model, 'time_14_45_to_15_00') ?>

    <?php // echo $form->field($model, 'time_15_00_to_15_15') ?>

    <?php // echo $form->field($model, 'time_15_15_to_15_30') ?>

    <?php // echo $form->field($model, 'time_15_30_to_15_45') ?>

    <?php // echo $form->field($model, 'time_15_45_to_16_00') ?>

    <?php // echo $form->field($model, 'time_16_00_to_16_15') ?>

    <?php // echo $form->field($model, 'time_16_15_to_16_30') ?>

    <?php // echo $form->field($model, 'time_16_30_to_16_45') ?>

    <?php // echo $form->field($model, 'time_16_45_to_17_00') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
