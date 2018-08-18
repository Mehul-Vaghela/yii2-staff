<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
use common\models\System;
use frontend\models\Route;

$this->title = 'Legal Practice Helpdesk login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="middle-box loginscreen animated fadeInDown">
    <div>
        <div class="text-center">
            <a href="/">
                <img src="/images/logo.png">
            </a>
        </div>
        <div class="help-block"></div>
        
        <div class="user-login">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= Alert::widget() ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'style' => 'width:100%;', 'name' => 'login-button']) ?>
            </div>
            <p class="text-center">
                <?=Html::a('Forgot Password', System::getBackendDomain().Route::getRoute(['route' => 'site-request-password-reset']))?>
            </p>

        <?php ActiveForm::end(); ?>
        </div>
        <p class="m-t text-center">
            <small>Legal Practice Helpdesk &copy; <?=date('Y')?></small>
        </p>
    </div>
</div>