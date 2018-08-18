<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\LinkStaffSubject */

$this->title = 'Update Link Staff Subject: ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Link Staff Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="link-staff-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'readonly' => 0
    ]) ?>

</div>
