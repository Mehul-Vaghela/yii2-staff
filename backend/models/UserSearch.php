<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `\backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */

    public $name;

    # employee application-related fields
    public $alias;
    public $mobile;
    public $datecreated;
    public $datesigned;

    public $city;
    public $assigned_roles;

    const SCENARIO_DEFAULT = 'SCENARIO_DEFAULT';
    const SCENARIO_VISA_HOLDER_EXPIRE = 'SCENARIO_VISA_HOLDER_EXPIRE';
    const SCENARIO_VISA_HOLDERS_ALL = 'SCENARIO_VISA_HOLDERS_ALL';
    const SCENARIO_VISA_HOLDER_EXPIRE_30_DAYS = 'SCENARIO_VISA_HOLDER_EXPIRE_30_DAYS';
    const SCENARIO_VISA_HOLDER_EXPIRE_60_DAYS = 'SCENARIO_VISA_HOLDER_EXPIRE_60_DAYS';
    const SCENARIO_VISA_HOLDER_EXPIRE_90_DAYS = 'SCENARIO_VISA_HOLDER_EXPIRE_90_DAYS';
    const SCENARIO_NEW_APPLICANTS = 'SCENARIO_NEW_APPLICANTS';
    const SCENARIO_ON_BOARDING = 'SCENARIO_ON_BOARDING';
    const SCENARIO_ON_BOARDING_CREATED = 'SCENARIO_ON_BOARDING_CREATED';
    const THIRTY_DAYS = 30;
    const SIXTY_DAYS = 60;
    const NINETY_DAYS = 90;
    const EMP_APPLICATION_STATUS_CREATED = 'created';
    const EMP_APPLICATION_STATUS_APPROVED = 'approved';
    const EMP_APPLICATION_STATUS_SUBMITTED= 'submitted';

    public function rules()
    {
        return

            [
                
                [
                    [
                    'id', 
                    'status', 
                    'created_at', 
                    'updated_at',
                    ], 
                    'integer'
                ],

            ];

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'assigned_roles' => 'Assigned Roles',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            # custom
            'fullName' => 'Full Name',
            'img_upload' => 'Image Upload',
            'employee_no' => 'Employee No.',
            'gender_id' => 'Gender',
            'employee_application_no' => 'Employee Application No.',
            'employee_status_id' => 'Employment Status',
            'employee_date_start' => 'Date of Employment',
            'payroll_id' => 'Payroll',
            'is_salary_packing' => 'Salary Packing'
        ];
    }

    public function scenarios(){
    # define which attributes are safe to accept input from a user for a particular scenario
        
        $scenarios = parent::scenarios();

        $attributes = [
                        'name',
                        'email',
                        'username',
                        'employee_no',
                        'status',
                        'created_at',
                        'updated_at',
                        'employee_application_status_id',
                        'visa_grant_date',
                        'visa_expiry_date',
                        # employee application-related
                        'alias',
                        'mobile',
                        'datecreated',
                        'datesigned'
                        ];

        $scenarios[self::SCENARIO_DEFAULT] = $attributes;
        $scenarios[self::SCENARIO_VISA_HOLDER_EXPIRE] = $attributes;
        $scenarios[self::SCENARIO_VISA_HOLDERS_ALL] = $attributes;
        $scenarios[self::SCENARIO_VISA_HOLDER_EXPIRE_30_DAYS] = $attributes;
        $scenarios[self::SCENARIO_VISA_HOLDER_EXPIRE_60_DAYS] = $attributes;
        $scenarios[self::SCENARIO_VISA_HOLDER_EXPIRE_90_DAYS] = $attributes;
        $scenarios[self::SCENARIO_NEW_APPLICANTS] = $attributes;
        $scenarios[self::SCENARIO_ON_BOARDING] = $attributes;
        $scenarios[self::SCENARIO_ON_BOARDING_CREATED] = $attributes;

        return $scenarios;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params=NULL)
    {
        $query = User::find()
                       ->joinWith('employeeApplication as employee_application_t');

        # add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['employee_no'] = [
            'asc' => ['user.employee_no' => SORT_ASC],
            'desc' => ['user.employee_no' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['alias'] = [
            'asc' => ['employee_application_t.alias' => SORT_ASC],
            'desc' => ['employee_application_t.alias' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['name'] = [
            'asc' => ["CONCAT(user.firstname,' ',user.lastname)" => SORT_ASC],
            'desc' => ["CONCAT(user.firstname,' ',user.lastname)" => SORT_DESC]
        ];

        $dataProvider->sort->attributes['mobile'] = [
            'asc' => ['employee_application_t.mobile' => SORT_ASC],
            'desc' => ['employee_application_t.mobile' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['datesigned'] = [
            'asc' => ['employee_application_t.datesigned' => SORT_ASC],
            'desc' => ['employee_application_t.datesigned' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['datecreated'] = [
            'asc' => ['employee_application_t.datecreated' => SORT_ASC],
            'desc' => ['employee_application_t.datecreated' => SORT_DESC],
        ];

        $this->load($params);

        if(!$this->validate()){
            # uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        # grid filtering conditions
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'user.is_employee' => $this->is_employee,
        ]);

        $query
            # employee application table
            ->andFilterWhere(['like', 'employee_application_t.alias', $this->alias])
            ->andFilterWhere(['like', 'employee_application_t.mobile', $this->mobile])
            ->andFilterWhere(['like', 'employee_application_t.datecreated', $this->datecreated])
            ->andFilterWhere(['like', 'employee_application_t.datesigned', $this->datesigned])
            # user table
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', "CONCAT(user.firstname,' ',user.lastname)", $this->name])
            ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.employee_no', $this->employee_no])
            ;

        # new applicants
        if($this->scenario == self::SCENARIO_NEW_APPLICANTS){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_SUBMITTED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            # Note: Commenting out the date filter as it is possible for applications in the previous month to be neglected if they are no longer visible
            #$query->andWhere(['between', 'DATE(employee_application_t.datecreated)', \common\models\System::getFirstDayOfMonth(), \common\models\System::getDate()]);
        }

        # on-boarding
        if($this->scenario == self::SCENARIO_ON_BOARDING_CREATED){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_CREATED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_on_boarding_status_id',$emp_status_id]);
            # Note: Commenting out the date filter as it is possible for applications in the previous month to be neglected if they are no longer visible
            #$query->andWhere(['between', 'DATE(employee_application_t.datecreated)', \common\models\System::getFirstDayOfMonth(), \common\models\System::getDate()]);
        }

        # on-boarding
        if($this->scenario == self::SCENARIO_ON_BOARDING){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_SUBMITTED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_on_boarding_status_id',$emp_status_id]);
            # Note: Commenting out the date filter as it is possible for applications in the previous month to be neglected if they are no longer visible
            #$query->andWhere(['between', 'DATE(employee_application_t.datecreated)', \common\models\System::getFirstDayOfMonth(), \common\models\System::getDate()]);
        }

        # all visa holders
        if($this->scenario == self::SCENARIO_VISA_HOLDERS_ALL){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_APPROVED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            $query->andWhere(['not', ['employee_application_t.visa_grant_date' => NULL]]);
            #$query->andWhere(['>=', 'employee_application_t.visa_expiry_date',\common\models\System::getDate()]);
        }
        # expired visas
        else if($this->scenario == self::SCENARIO_VISA_HOLDER_EXPIRE){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_APPROVED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            $query->andWhere(['not', ['employee_application_t.visa_grant_date' => NULL]]);
            $query->andWhere(['<', 'employee_application_t.visa_expiry_date',\common\models\System::getDate()]);
        }
        # still valid within 30+ days
        else if($this->scenario == self::SCENARIO_VISA_HOLDER_EXPIRE_30_DAYS){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_APPROVED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            $query->andWhere(['not', ['employee_application_t.visa_grant_date' => NULL]]);
            $query->andWhere(['>=', 'employee_application_t.visa_expiry_date',date('Y-m-d',strtotime("+".self::THIRTY_DAYS." day", strtotime(\common\models\System::getDate())))]);
        }
        # still valid within 60+ days
        else if($this->scenario == self::SCENARIO_VISA_HOLDER_EXPIRE_60_DAYS){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_APPROVED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            $query->andWhere(['not', ['employee_application_t.visa_grant_date' => NULL]]);
            $query->andWhere(['>=', 'employee_application_t.visa_expiry_date',date('Y-m-d',strtotime("+".self::SIXTY_DAYS." day", strtotime(\common\models\System::getDate())))]);
        }
        # still valid within 90+ days
        else if($this->scenario == self::SCENARIO_VISA_HOLDER_EXPIRE_90_DAYS){
            $emp_status_obj=\backend\models\EmployeeApplicationStatus::findOne(['alias' => self::EMP_APPLICATION_STATUS_APPROVED]);
            $emp_status_id=!empty($emp_status_obj)?$emp_status_obj->id:0;
            $query->andWhere(['=', 'employee_application_t.employee_application_status_id',$emp_status_id]);
            $query->andWhere(['not', ['employee_application_t.visa_grant_date' => NULL]]);
            $query->andWhere(['>=', 'employee_application_t.visa_expiry_date',date('Y-m-d',strtotime("+".self::NINETY_DAYS." day", strtotime(\common\models\System::getDate())))]);
        }
        return $dataProvider;
    }
}
