<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $img
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Staff extends \common\models\User
{
    const SCENARIO_CREATE_STAFF = 'create-staff';
    const SCENARIO_UPDATE_STAFF = 'update-staff';
    public $password;
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
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'img' => 'Img',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getRoute($params)
    {
        $data = NULL;
        $route = array();
        if (!empty($params['route'])) {
            if ($params['route'] == "staff-view") {

                $route[] = '/staff';
                $route[] = 'view';

                $data['id'] = $this->id;
            } else if ($params['route'] == "staff-update") {

                $route[] = '/staff';
                $route[] = 'update';

                $data['id'] = $this->id;
            } else if ($params['route'] == "staff-delete") {

                $route[] = '/staff';
                $route[] = 'delete';

                $data['id'] = $this->id;
            } else if ($params['route'] == "staff-create") {

                $route[] = '/staff';
                $route[] = 'create';
            }
        } else {
            $route[] = '/site';
            $route[] = 'login';
        }

        $route = implode('/', $route);

        if (!empty($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                if(!empty($v)) $data[urlencode($k)] = urlencode((string)$v);
            }
        }

        if (!empty($data)) {
            $data = \common\models\System::getify($data);
            $route .= '?' . $data;
        }
        return $route;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE_STAFF] = ['firstname','lastname','username','email','password'];
        $scenarios[self::SCENARIO_UPDATE_STAFF] = ['firstname','lastname'];

        return $scenarios;
    }

    public function processInputData($params = NULL)
    {
        if($this->scenario == self::SCENARIO_CREATE_STAFF){
            if ($this->validate()) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
                if($this->save()){
                    /*$auth_obj=new AuthAssignment();
                    $auth_obj->item_name='staff';
                    $auth_obj->user_id=$this->id;
                    $auth_obj->save();*/
                    return true;
                }
                return false;
            }
        }else if($this->scenario == self::SCENARIO_UPDATE_STAFF){
            if ($this->validate() && $this->save()) {
                return true;
            }
        }
        return false;
    }

}
