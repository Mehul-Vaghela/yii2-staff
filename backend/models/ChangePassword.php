<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class ChangePassword extends Model
{

	public $previousPass;
	public $currentPass;
	public $matchPass;

	public function rules(){

		return [
			[['previousPass', 'currentPass', 'matchPass'], 'required'],
			['previousPass','findPasswords'],
			['matchPass','compare','compareAttribute'=>'currentPass'],
		];
		
	}
	
	public function findPasswords($attribute, $params)
	{

		$userModel = Yii::$app->user->identity;
		$password = $userModel->password_hash;

		if(!Yii::$app->security->validatePassword($this->previousPass, $password))
			$this->addError($attribute,'Old password is incorrect');

	}
	
	public function attributeLabels()
	{
		
		return [
			'previousPass'=>'Previous Password',
			'currentPass'=>'New Password',
			'matchPass'=>'Repeat New Password',
		];

	}
	
	public function savePassword()
	{
	# this is a function that save the new password of login user
		
		$userModel = Yii::$app->user->identity;
		$userModel->setPassword($this->currentPass);
		
		if($userModel->save())
		{
			
    		return true;

    	}

    	return false;

	}

}

?>