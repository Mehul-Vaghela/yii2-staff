<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$can_admin = Yii::$app->user->can('admin');
$can_staff = Yii::$app->user->can('staff');


?>

    <li class="nav-menu-top account <?= Yii::$app->controller->id == 'account' ? 'active' : '' ?>">
        <a href="/"><i class="glyphicon glyphicon-lock"></i> <span class="nav-label">My Account</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li class="nav-menu account-change-password">
                <?= Html::a('Change Password', [\backend\models\Route::getRoute(['route' => 'change-password'])]) ?>
            </li>
            <?php
            if ($can_admin) {
                ?>
                <li class="nav-menu account-update-image">
                    <?= Html::a('Update Image', [\backend\models\Route::getRoute(['route' => 'update-image'])]) ?>
                </li>
                <?php
            }
            ?>

        </ul>
    </li>

    <li class="nav-menu-top staff <?= Yii::$app->controller->id == 'staff' ? 'active' : '' ?>">
        <a href="/"><i class="glyphicon glyphicon-user"></i> <span class="nav-label">Users</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level staff">
            <li class="nav-menu staff-index staff-view staff-update">
                <?= Html::a('View Record', [\backend\models\Route::getRoute(['route' => 'staff-index'])]) ?>
            </li>
            <?php
            if ($can_admin) {
                ?>
                <li class="nav-menu staff-create">
                    <?= Html::a('New User', [\backend\models\Route::getRoute(['route' => 'staff-create'])]) ?>
                </li>
                <?php
            }
            ?>

        </ul>
    </li>
<?php if ($can_admin) {
    ?>
    <li class="nav-menu-top subject <?= Yii::$app->controller->id == 'subject' ? 'active' : '' ?>">
        <a href="/"><i class="glyphicon glyphicon-list-alt"></i> <span class="nav-label">Subject</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level subject">
            <li class="nav-menu subject-index subject-view subject-update">
                <?= Html::a('View Record', [\backend\models\Route::getRoute(['route' => 'subject-index'])]) ?>
            </li>
            <li class="nav-menu subject-create">
                <?= Html::a('New Subject', [\backend\models\Route::getRoute(['route' => 'subject-create'])]) ?>
            </li>
        </ul>
    </li>

    <?php
} ?>
    <li class="nav-menu-top link-staff-subject <?= Yii::$app->controller->id == 'link-staff-subject' ? 'active' : '' ?>">
        <a href="/"><i class="glyphicon glyphicon-list-alt"></i> <span class="nav-label">Link Staff Subject</span> <span
                    class="fa arrow"></span></a>
        <ul class="nav nav-second-level link-staff-subject">
            <li class="nav-menu link-staff-subject-index link-staff-subject-view link-staff-subject-update">
                <?= Html::a('View Record', [\backend\models\Route::getRoute(['route' => 'link-staff-subject-index'])]) ?>
            </li>
            <li class="nav-menu link-staff-subject-create">
                <?= Html::a('New Record', [\backend\models\Route::getRoute(['route' => 'link-staff-subject-create'])]) ?>
            </li>
        </ul>
    </li>

<?php

# highlight for non-1st level menu
$this->registerJs("
    $('." . Html::encode(Yii::$app->controller->id) . "-" . Html::encode(Yii::$app->controller->action->id) . "').addClass('active');", \yii\web\View::POS_READY);
?>