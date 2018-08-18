<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use backend\models\ChangePassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for User model.
 */
class AccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=> [
                'class'=>AccessControl::classname(),
                'rules'=>[
                    [
                        'actions'=>['change-password'],
                        'allow'=>true,
                        'roles'=>['@']
                    ],
                    [
                        'actions'=>['update-image'],
                        'allow'=>true,
                        'roles'=>['@']
                    ]
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
     * Update the password of the current user.
     * If the password has been updated, it will prompt a success message.
     * @param string $id
     * @return User the loaded model
     */
    public function actionChangePassword() {

        $this->layout = 'main-blank';

        $model = new ChangePassword();

        if($model->load(Yii::$app->request->post()) && 
            $model->validate() && 
            $model->savePassword()
            ){
        
            $model = new ChangePassword();
        
            Yii::$app->session->setFlash('success', 'You have successfully updated your password.');

        }

        return $this->render('change-password', [
                'model' => $model
            ]);

    }

    public function actionUpdateImage() {

        # set layout of the page
        $this->layout = 'main-blank';

        # find the user record using the session
        $model = User::findOne(['id' => Yii::$app->user->identity->id]);

        # if user record is found
        if(!empty($model)){

            # set scenario
            $model->scenario = User::SCENARIO_BACKEND_IMG_UPLOAD_APPLICATION;

            # if post data is present and loaded to the model
            if(Yii::$app->request->post() && $model->load(Yii::$app->request->post())){

                $success = true; # assume successful operation
            
                # if there is an image uploaded
                if(!empty($model->img_upload_base64)){

                    if($model->uploadImage() && $model->save()){
                    # upload has been successful

                    }
                    else{
                    # an error occured

                        $success = false;

                    }

                }

                # if removal of the image is set
                if(($model->remove_img==1)){

                    if($model->removeImage() && $model->save()){

                    }
                    else{
                    # an error occured

                        $success = false;

                    }

                }

                if($success){

                    # set success message
                    Yii::$app->session->setFlash('success', 'The operation was successful.');

                }
                else{

                    # set error message
                    Yii::$app->session->setFlash('error', 'Sorry, an error has occured while performing your request. Please check your input and try again.');

                }

                # redirect
                return $this->redirect([\backend\models\Route::getRoute(['route' => 'update-image'])]);

            }

        }

        return $this->render('update-image', [
                'model' => $model
            ]);

    }
    
}
