<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\base\Security;
use common\models\System;
use frontend\models\User;

/**
 * This is the model class for table "user_email_validation".
 *
 * @property string $id
 * @property string $user_id
 * @property string $validation_key
 * @property string $datecreated
 * @property string $dateexpiration
 * @property integer $is_used
 *
 * @property User $user
 */
class UserEmailValidation extends \yii\db\ActiveRecord
{

    const EXPIRATION = 6; # hours

    const RESULT_ERROR_GENERAL                      = 'result-error-general';
    const RESULT_ERROR_NO_ACCOUNT                   = 'result-error-no-account';
    const RESULT_ERROR_IS_EXPIRED                   = 'result-error-is-expired';
    const RESULT_ERROR_VALIDATION_KEY_INVALID       = 'result-error-validation-key-invalid';
    const RESULT_SUCCESS                            = 'result-success';
    const RESULT_SUCCESS_VIA_EMPLOYEE_APPLICATION   = 'result-success-via-employee-application';
    const RESULT_WARNING_ALREADY_ACTIVATED          = 'result-warning-already-activated';
    const RESULT_WARNING_ALREADY_USED               = 'result-warning-already-used';

    const MODE_EMPLOYEE_APPLICATION_FRONTEND_CREATE = 'employee-application'; # lowercased, used in url

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_email_validation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'validation_key'], 'required'],
            [['user_id', 'is_used'], 'integer'],
            [['datecreated'], 'safe'],
            [['dateexpiration'], 'safe'],
            [['validation_key'], 'string', 'max' => 40],
            [['user_id', 'validation_key'], 'unique', 'targetAttribute' => ['user_id', 'validation_key'], 'message' => 'The combination of User ID and Validation Key has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'validation_key' => 'Validation Key',
            'datecreated' => 'Date Created',
            'dateexpiration' => 'Date Expiration',
            'is_used' => 'Is Used',
        ];
    }

    public function initiate($params = NULL){

        if(!empty($params['user_id'])) $this->user_id = $params['user_id'];

        if(!empty($params['validation_key'])) $this->validation_key = $params['validation_key'];
        else $this->validation_key = System::getRandomHash();
        
        if(!empty($params['datecreated'])) $this->datecreated = $params['datecreated'];
        else $this->datecreated = date("Y-m-d H:i:s");
        
        if(!empty($params['dateexpiration'])) $this->dateexpiration = $params['dateexpiration'];
        else $this->dateexpiration = date("Y-m-d H:i:s", strtotime('+'.UserEmailValidation::EXPIRATION.' hours'));
        
        if(!empty($params['is_used'])) $this->is_used = $params['is_used'];
        else $this->is_used = 0;

        return true;

    }

    public static function getRoute($params){

        if(!empty($params['route']) && $params['route']=="user-email-validation-request"){

            $route = array();

            $route[] = "/user-email-validation";
            $route[] = "request";

            $route = implode("/", $route);

            return $route;

        }else if(!empty($params['route']) && $params['route']=="user-email-validation-activate"){

            $route = array();

            $route[] = "/user-email-validation";
            $route[] = "activate";

            $route = implode("/", $route);

            return $route;

        }

        return NULL;

    }

    public function isExpired(){

        $datetime = strtotime(System::getDateTime());
        $dateexpiration = strtotime($this->dateexpiration);

        if($datetime > $dateexpiration) return true;
        else return false; 

    }

    public static function requestValidation($params = NULL){
    # this is the process of generating a validation link

        if(!empty($params['email'])){

            # check if there is a non-blocked user account associated with the email address
            $userModel = User::find()
                                ->andFilterWhere(['email' => $params['email']])
                                ->andFilterWhere(['>=', 'status', 10])
                                ->one();

            # if there is one
            if($userModel){

                # if it is not yet validated
                if(!$userModel->isValidated()){

                    # assume operation will fail
                    $ok = false;

                    # check if there is an existing record for the email address which is not used and still not expired
                    $userEmailValidationModel = UserEmailValidation::find()
                        ->andFilterWhere(['user_id' => $userModel->id])
                        ->andFilterWhere(['is_used' => 0])
                        ->andFilterWhere(['>=', 'dateexpiration', System::getDateTime()])
                        ->one();
        
                    if($userEmailValidationModel){

                        $ok = true;

                    }
                    else{

                        $userEmailValidationModel = new UserEmailValidation();
                        $userEmailValidationModel->initiate(['user_id' => $userModel->id]);

                        if($userEmailValidationModel->validate() && 
                            $userEmailValidationModel->save()){

                            $ok = true;

                        }

                    }

                    if($ok){

                        $email = new Email();

                        $email->to = $userModel->email;
                        $email->from = Yii::$app->params['noreplyEmail'];
                        $email->name = "BioGiene Pty Ltd Tailored Hygiene Services & Systems";
                        $email->subject = "Account Validation of ".$userModel->email." at ".System::getSystemDomain();

                        $mode = !empty($params['mode']) ? $params['mode'] : NULL;

                        $link = System::getDomainAsLink().UrL::toRoute([$userEmailValidationModel::getRoute(['route' => 'user-email-validation-activate']), 'email' => $userModel->email, 'key' => $userEmailValidationModel->validation_key, 'mode' => $mode]);

                        $email->body = "<p>Hi ".$userModel->previewName.",</p>".
                                        "<p>Thank you very much for registering to our website.</p>".
                                        "<p>To complete the registration process, please click on the link below and have your account validated:</p>".
                                        "<a href='".$link."'>".$link."</a>".
                                        "<p>The link can only be used within ".UserEmailValidation::EXPIRATION." hours of its creation. If it expires, you will need to request a new one.</p>".
                                        "<p>Kind regards,</p>".
                                        "<p>&nbsp;&nbsp;</p>".
                                        "<p>The Team at ".System::getSystemDomain()."</p>"
                                        ;

                        if($email->sendEmail()){

                            return self::RESULT_SUCCESS;

                        }

                    }
                    else return self::RESULT_ERROR_GENERAL;

                }
                else return self::RESULT_WARNING_ALREADY_ACTIVATED;

            }
            else return self::RESULT_ERROR_NO_ACCOUNT;

        }

        return false;

    }

    public static function activate($params = NULL){

        if(!empty($params['email'])){

            # get the user record based on email address
            $userModel = User::find()
                    ->andFilterWhere(['email' => $params['email']])
                    ->andFilterWhere(['>=', 'status', 10])
                    ->one();
                    
            if($userModel){
            # if the record is found

                # get the user email validation record based on user_id and validation key
                $userEmailValidationModel = UserEmailValidation::findOne(['user_id' => $userModel->id, 'validation_key' => $params['key']]);

                if($userEmailValidationModel){
                # if the record is found

                    if($userModel->isValidated()){

                        return self::RESULT_WARNING_ALREADY_ACTIVATED;

                    }
                    else if($userEmailValidationModel->is_used == 1){

                        return self::RESULT_WARNING_ALREADY_USED;

                    }
                    else if($userEmailValidationModel->isExpired()){

                        return self::RESULT_ERROR_IS_EXPIRED;

                    }
                    else{
                    # OK

                        $userModel->is_validated = 1;
                        $userModel->validation_key = NULL;

                        if($userModel->save()){

                            $userEmailValidationModel->is_used = 1;
                            $userEmailValidationModel->dateused = System::getDateTime();

                            if($userEmailValidationModel->save()){

                                if($params['mode'] && $params['mode'] == UserEmailValidation::MODE_EMPLOYEE_APPLICATION_FRONTEND_CREATE){

                                    $email = new Email();

                                    $email->to = $userModel->email;
                                    $email->from = Yii::$app->params['noreplyEmail'];
                                    $email->name = "BioGiene Pty Ltd Tailored Hygiene Services & Systems";
                                    $email->subject = "Account Validation of ".$userModel->email." at ".System::getSystemDomain()." has been successful";

                                    $email->body = "<p>Hi ".$userModel->previewName.",</p>".
                                                    "<p>Thank you for validating your account.</p>".
                                                    "<p>Your application is now in queue in our system and will undergo processing.</p>".
                                                    "<p>We will notify you via email for further instructions.</p>".
                                                    "<p>This is a machine-generated email, please do not reply as replies made to this email address may not be responded to.</p>".
                                                    "<p>Kind regards,</p>".
                                                    "<p>&nbsp;&nbsp;</p>".
                                                    "<p>The Team at ".System::getSystemDomain()."</p>"
                                                    ;

                                    if($email->sendEmail()){
                                    # email sent

                                    }
                                    else{
                                    # email did NOT send

                                    }

                                    return self::RESULT_SUCCESS_VIA_EMPLOYEE_APPLICATION;

                                }
                                else{

                                    return self::RESULT_SUCCESS;

                                }

                            }

                        }

                    }

                }
                else{

                    return self::RESULT_ERROR_VALIDATION_KEY_INVALID;

                }

            }

        }

        return false;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
