<?php
namespace backend\models;

use common\models\Email;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use common\models\User;
use common\models\System;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $email = new Email();

        $email->to = $this->email;
        $email->from = Yii::$app->params['noreplyEmail'];
        $email->name = "Password Reset";
        $email->subject = 'Password reset for ' . Yii::$app->name;

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

        $email->body =  "<p>Hello ".Html::encode($user->firstname).",</p>".
                        "<p>Your Username Is: ".$user->username."</p>".
                        "<p>Follow the link below to reset your password:</p>".
                        "<p>".Html::a(Html::encode($resetLink), $resetLink)."</p>".
                        "<p>Kind regards,</p>".
                        "<p>&nbsp;&nbsp;</p>".
                        "<p>The Team at ".System::getSystemDomain()."</p>"
                        ;

        if($email->sendEmail()){
            return true;
        }

        return false;
        /*return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();*/
    }
}
