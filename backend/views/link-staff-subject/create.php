<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\LinkStaffSubject */

$this->title = 'Create Link Staff Subject';
$this->params['breadcrumbs'][] = ['label' => 'Link Staff Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-staff-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'readonly' => 0
    ]) ?>

</div>
