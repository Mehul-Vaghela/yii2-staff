<?php

namespace backend\models;

use common\models\System;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \common\models\User
{
    const SCENARIO_BACKEND_IMG_UPLOAD_APPLICATION = 'SCENARIO_BACKEND_IMG_UPLOAD_APPLICATION';
    const default_img_path = "/images/profile/default.jpg";
    public $remove_img = 0;
    public $img_upload = NULL;
    public $img_upload_base64;
    public $role_input;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
        ];
    }
    public function scenarios(){
        # define which attributes are safe to accept input from a user for a particular scenario

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_DEFAULT] = [ ];


        $scenarios[self::SCENARIO_BACKEND_IMG_UPLOAD_APPLICATION] = [
            'img',
            'remove_img',
            'img_upload',
            'img_upload_base64'
        ];


        return $scenarios;
    }

    public function processData(){
        # this is a function that processes the input data during create and update operations

        if(!empty($this->password))
        {
            $this->setPassword($this->password);
        }

        if($this->validate() && $this->save())
        {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getImagePath($params = NULL){

        $img_path = "/images/profile/".$this->img.".jpg";

        if(!empty($this->img) && file_exists(Yii::getAlias('@backend')."/web".$img_path))
        {
            # do nothing
        }
        else{
            $img_path = self::default_img_path;
        }

        if(!empty($params['type']) && $params['type']=="web") return System::getUrl(['type' => 'web']).$img_path;
        else if(!empty($params['type']) && $params['type']=="web-secure") return System::getUrl(['type' => 'web-secure']).$img_path;

        return $img_path;
    }

    public function hasImage(){
        $img_path = $this->getImagePath();

        if($img_path!=self::default_img_path) return true;
        else return false;
    }

    public function uploadImage($params=NULL){
        if(!empty($this->img_upload_base64))
        {
            $img_path = self::default_img_path; # get the default image path
            $hash = NULL; # create instance of hash

            while(file_exists(Yii::getAlias('@backend').'/web'.$img_path))
            { # while file path is existing
                $hash = \common\models\System::getRandomHash(); # generate a new hash for the image (to avoid collisions)
                $img_path = '/images/profile/'.$hash.'.jpg'; # set the hash as part of the new path for the image
            }

            $data = $this->img_upload_base64;
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));

            if(file_put_contents(Yii::getAlias('@backend').'/web'.$img_path, $data))
            { # store the image on the server
                if(!empty($params)){
                    if($params['action'] == 'employee_request'){
                        # it's employee request
                        # do not remove image untill it's get approved
                    }
                    else{
                        $this->removeImage(); # remove the current image of the account
                    }
                }else{
                    $this->removeImage(); # remove the current image of the account
                }

                # $this->img_upload_base64 = NULL;
                $this->img = $hash; # store the new hash to the user's account
                return true;
            }
        }
        return false; # default response when upload fails
    }

    public function removeImage(){
        $img_path = $this->getImagePath();

        if($img_path!=self::default_img_path)
        {
            unlink(Yii::getAlias('@backend')."/web".$img_path);
            $this->img = NULL;
        }
        return true;
    }
    public function getUserRole(){
        $auth_table=AuthAssignment::findOne(['user_id'=>$this->id]);
        if(is_object($auth_table)){
            return $auth_table->item_name;
        }else{
            return 'Not Defined';
        }

    }
}
