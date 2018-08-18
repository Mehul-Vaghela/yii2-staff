<?php

namespace backend\controllers;

use backend\models\Subject;
use common\models\User;
use Yii;
use backend\models\Staff;
use backend\models\StaffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin','staff'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin','staff'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['admin','staff'],
                    ],
                    [
                        'actions' => ['get-user-list'],
                        'allow' => true,
                        'roles' => ['admin','staff'],
                    ],
                    [
                        'actions' => ['get-subject-list'],
                        'allow' => true,
                        'roles' => ['admin','staff'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $is_admin=Yii::$app->user->can('admin');
        if($is_admin){
            $searchModel->is_admin=1;
        }else{
            $searchModel->staff_id=Yii::$app->user->id;
            $searchModel->is_admin=0;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'readonly' => 1
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();

        if (Yii::$app->request->post()) {
            $model->scenario = Staff::SCENARIO_CREATE_STAFF;
            $model->load(Yii::$app->request->post());
            $model->processInputData();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'readonly' => 0
        ]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $model->scenario = Staff::SCENARIO_UPDATE_STAFF;
            $model->load(Yii::$app->request->post());
            $model->processInputData();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'readonly' => 0
        ]);
    }

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetUserList($q = NULL, $role = NULL, $mode = '<=', $limit = NULL){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        # if the user is an admin
        if(Yii::$app->user->can('admin')){
            $out['results'] = array();

            $sites = User::find()->where(['!=','id',Yii::$app->user->id])->asArray()->all();

            if (count($sites) > 0
                && !empty($sites[0])
            ) {
                foreach ($sites as $site) {
                    $out['results'][] = [
                        'id' => $site['id'],
                        'title' => $site['username'],
                        'alias' => $site['email'],
                        'text' => $site['username']
                    ];
                }
            }
            return $out;
        }
        else{
            # the user is NOT an admin
            $out['results'] = array();

            $sites = User::find()->where(['id'=>Yii::$app->user->id])->asArray()->all();

            if (count($sites) > 0
                && !empty($sites[0])
            ) {
                foreach ($sites as $site) {
                    $out['results'][] = [
                        'id' => $site['id'],
                        'title' => $site['username'],
                        'alias' => $site['email'],
                        'text' => $site['username']
                    ];
                }
            }
            return $out;
        }
    }
    public function actionGetSubjectList($q = NULL, $role = NULL, $mode = '<=', $limit = NULL){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        # if the user is an admin
            $out['results'] = array();

            $sites = Subject::find()->where(['is_active'=>1])->asArray()->all();

            if (count($sites) > 0
                && !empty($sites[0])
            ) {
                foreach ($sites as $site) {
                    $out['results'][] = [
                        'id' => $site['id'],
                        'title' => $site['title'],
                        'alias' => $site['alias'],
                        'text' => $site['title']
                    ];
                }
            }
            return $out;

    }
}
