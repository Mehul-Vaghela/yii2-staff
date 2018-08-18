<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => 0,
        'striped' => 0,
        'condensed' => 0,
        'responsive' => 0,
        'id' => 'user_grid',
        'toolbar' => [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], ['data-pjax' => false, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
            ],
            '{export}',
            '{toggleData}'
        ],
        'panel' => [
            'type' => 'hidden',
        ],
        'exportConfig' => [
            GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'user-' . date('Y-m-d H:i:s')],
            GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'user-' . date('Y-m-d H:i:s')],
            GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'user-' . date('Y-m-d H:i:s')],
            GridView::EXCEL => ['label' => 'Export as EXCEL', 'filename' => 'user-' . date('Y-m-d H:i:s')],
            GridView::TEXT => ['label' => 'Export as TEXT', 'filename' => 'user-' . date('Y-m-d H:i:s')],
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'hover' => 1,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'firstname',
            'lastname',
            'email:email',
            [
                'label' => 'Role',
                'attribute' => 'role_string',
                'value' => function ($data){
                    return $data->getUserRole();
                }
            ],


            [
                'attribute' => 'action',
                'label' => '',
                'format' => 'raw',
                'value' => function ($data){

                    $buttons = array();

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        [$data->getRoute(['route' => 'staff-view'])],
                        [
                            'class' => 'btn btn-default',
                            'style' => 'margin: 0',
                            'title' => 'View',
                            'data-pjax' => 0
                        ]
                    );

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        [$data->getRoute(['route' => 'staff-update'])],
                        [
                            'class' => 'btn btn-default',
                            'style' => 'margin: 0',
                            'title' => 'Edit',
                            'data-pjax' => 0
                        ]
                    );

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        [$data->getRoute(['route' => 'staff-delete'])],
                        [
                            'class' => 'btn btn-default',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this record?',
                                'method' => 'post'
                            ],
                            'style' => 'margin: 0',
                            'title' => 'Delete',
                            'data-pjax' => 0
                        ]
                    );

                    $buttons = implode(" ", $buttons);

                    return $buttons;

                },
            ],
        ],
    ]); ?>
</div>
