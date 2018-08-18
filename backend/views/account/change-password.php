<?php

use yii\db\Query;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-8 col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Change Password</h5>
                </div>
                <div class="ibox-content">
                    <p>You can reset your password by filling up the following details:</p>

                    <?php 

                    $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'previousPass')->passwordInput(['autofocus' => true, 'placeholder' => 'Current Password'])->label(false) ?>

                    <?= $form->field($model, 'currentPass')->passwordInput(['placeholder' => 'New Password'])->label(false) ?>

                    <?= $form->field($model, 'matchPass')->passwordInput(['placeholder' => 'Repeat Password'])->label(false) ?>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
