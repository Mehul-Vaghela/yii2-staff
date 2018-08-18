<?php
use     yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\BaseHtml;
use yii\helpers\URL;

Modal::begin([
    'options' => [
        'id' => 'modal-md',
        'tabindex' => false # important for Select2 to work properly
    ],
    'header' => '<span id="modal-md-header-title"></span>',
    'headerOptions' => ['id' => 'modal-md-header'],
    'size' => 'modal-md',
    'clientOptions' => ['keyboard' => true, 'backdrop' => 'static'] # try keyboard = FALSE
    # 'clientOptions' => ['keyboard' => TRUE]
]);
?>
<div id="modal-md-content"></div>
<?php
Modal::end();
?>

<?php
Modal::begin([
    'options' => [
        'id' => 'modal-lg',
        'tabindex' => false # important for Select2 to work properly
    ],
    'header' => '<span id="modal-lg-header-title"></span>',
    'headerOptions' => ['id' => 'modal-lg-header'],
    'size' => 'modal-lg',
    'clientOptions' => ['keyboard' => true, 'backdrop' => 'static'] # previous value: keyboard = FALSE
    # 'clientOptions' => ['keyboard' => TRUE]
]);
?>

<div id="modal-lg-content"></div>
<?php
Modal::end();
?>
