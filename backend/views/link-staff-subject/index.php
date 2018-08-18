<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LinkStaffSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Link Staff Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-staff-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Link Staff Subject', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bordered' => 0,
        'striped' => 0,
        'condensed' => 0,
        'responsive' => 0,
        'id' => 'link_grid',
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
            GridView::CSV => ['label' => 'Export as CSV', 'filename' => 'link-' . date('Y-m-d H:i:s')],
            GridView::HTML => ['label' => 'Export as HTML', 'filename' => 'link-' . date('Y-m-d H:i:s')],
            GridView::PDF => ['label' => 'Export as PDF', 'filename' => 'link-' . date('Y-m-d H:i:s')],
            GridView::EXCEL => ['label' => 'Export as EXCEL', 'filename' => 'link-' . date('Y-m-d H:i:s')],
            GridView::TEXT => ['label' => 'Export as TEXT', 'filename' => 'link-' . date('Y-m-d H:i:s')],
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'hover' => 1,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'label' => 'Person Name',
                'attribute' => 'user_string',
                'value' => 'user.fullName'
            ],
            [
                'label' => 'Subject Name',
                'attribute' => 'subject_string',
                'value' => 'subject.title'
            ],
            [
                'label' => 'Day',
                'attribute' => 'day_id',
                'value' => function($data){
                    return Yii::$app->params['day'][$data->day_id];
                }
            ],
            'time_09_00_to_09_15',
            'time_09_15_to_09_30',
            'time_09_30_to_09_45',
            'time_09_45_to_10_00',
            'time_10_00_to_10_15',
            'time_10_15_to_10_30',
            'time_10_30_to_10_45',
            'time_10_45_to_11_00',
            'time_11_00_to_11_15',
            'time_11_15_to_11_30',
            'time_11_30_to_11_45',
            'time_11_45_to_12_00',
            'time_12_00_to_12_15',
            'time_12_15_to_12_30',
            'time_12_30_to_12_45',
            'time_12_45_to_13_00',
            'time_13_00_to_13_15',
            'time_13_15_to_13_30',
            'time_13_30_to_13_45',
            'time_13_45_to_14_00',
            'time_14_00_to_14_15',
            'time_14_15_to_14_30',
            'time_14_30_to_14_45',
            'time_14_45_to_15_00',
            'time_15_00_to_15_15',
            'time_15_15_to_15_30',
            'time_15_30_to_15_45',
            'time_15_45_to_16_00',
            'time_16_00_to_16_15',
            'time_16_15_to_16_30',
            'time_16_30_to_16_45',
            'time_16_45_to_17_00',
            'is_active',
            'date_created',
            'date_updated',

            [
                'attribute' => 'action',
                'label' => '',
                'format' => 'raw',
                'value' => function ($data){

                    $buttons = array();

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        [$data->getRoute(['route' => 'link-staff-subject-view'])],
                        [
                            'class' => 'btn btn-default',
                            'style' => 'margin: 0',
                            'title' => 'View',
                            'data-pjax' => 0
                        ]
                    );

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        [$data->getRoute(['route' => 'link-staff-subject-update'])],
                        [
                            'class' => 'btn btn-default',
                            'style' => 'margin: 0',
                            'title' => 'Edit',
                            'data-pjax' => 0
                        ]
                    );

                    $buttons[] = Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        [$data->getRoute(['route' => 'link-staff-subject-delete'])],
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
