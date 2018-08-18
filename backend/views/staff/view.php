<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Staff */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Action"><span
                    class="glyphicon glyphicon-cog"></span</button>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <?= Html::a('<span class="glyphicon glyphicon-pencil m-r-xs" title="Update"></span>Update', [$model->getRoute(['route' => 'staff-update'])], ['class' => '']) ?>
            </li>
            <li>
                <?= Html::a('<span class="glyphicon glyphicon-trash m-r-xs" title="Delete"></span>Delete', [$model->getRoute(['route' => 'staff-delete'])], [
                    'class' => '',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </li>
        </ul>
    </div>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'readonly' => 1
    ]) ?>

</div>
