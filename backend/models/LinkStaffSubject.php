<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "link_staff_subject".
 *
 * @property string $id
 * @property string $user_id
 * @property string $subject_id
 * @property int $day_id
 * @property int $time_09_00_to_09_15
 * @property int $time_09_15_to_09_30
 * @property int $time_09_30_to_09_45
 * @property int $time_09_45_to_10_00
 * @property int $time_10_00_to_10_15
 * @property int $time_10_15_to_10_30
 * @property int $time_10_30_to_10_45
 * @property int $time_10_45_to_11_00
 * @property int $time_11_00_to_11_15
 * @property int $time_11_15_to_11_30
 * @property int $time_11_30_to_11_45
 * @property int $time_11_45_to_12_00
 * @property int $time_12_00_to_12_15
 * @property int $time_12_15_to_12_30
 * @property int $time_12_30_to_12_45
 * @property int $time_12_45_to_13_00
 * @property int $time_13_00_to_13_15
 * @property int $time_13_15_to_13_30
 * @property int $time_13_30_to_13_45
 * @property int $time_13_45_to_14_00
 * @property int $time_14_00_to_14_15
 * @property int $time_14_15_to_14_30
 * @property int $time_14_30_to_14_45
 * @property int $time_14_45_to_15_00
 * @property int $time_15_00_to_15_15
 * @property int $time_15_15_to_15_30
 * @property int $time_15_30_to_15_45
 * @property int $time_15_45_to_16_00
 * @property int $time_16_00_to_16_15
 * @property int $time_16_15_to_16_30
 * @property int $time_16_30_to_16_45
 * @property int $time_16_45_to_17_00
 * @property int $is_active
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Subject $subject
 * @property User $user
 */
class LinkStaffSubject extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE_LINK = 'create-link';
    const SCENARIO_UPDATE_LINK = 'update-link';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link_staff_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'subject_id', 'day_id', 'time_09_00_to_09_15', 'time_09_15_to_09_30', 'time_09_30_to_09_45', 'time_09_45_to_10_00', 'time_10_00_to_10_15', 'time_10_15_to_10_30', 'time_10_30_to_10_45', 'time_10_45_to_11_00', 'time_11_00_to_11_15', 'time_11_15_to_11_30', 'time_11_30_to_11_45', 'time_11_45_to_12_00', 'time_12_00_to_12_15', 'time_12_15_to_12_30', 'time_12_30_to_12_45', 'time_12_45_to_13_00', 'time_13_00_to_13_15', 'time_13_15_to_13_30', 'time_13_30_to_13_45', 'time_13_45_to_14_00', 'time_14_00_to_14_15', 'time_14_15_to_14_30', 'time_14_30_to_14_45', 'time_14_45_to_15_00', 'time_15_00_to_15_15', 'time_15_15_to_15_30', 'time_15_30_to_15_45', 'time_15_45_to_16_00', 'time_16_00_to_16_15', 'time_16_15_to_16_30', 'time_16_30_to_16_45', 'time_16_45_to_17_00', 'is_active'], 'integer'],
            [['day_id'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['user_id', 'subject_id', 'day_id'], 'unique', 'targetAttribute' => ['user_id', 'subject_id', 'day_id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Select Staff Person',
            'subject_id' => 'Select Subject',
            'day_id' => 'Select Day',
            'time_09_00_to_09_15' => 'Time 09 00 To 09 15',
            'time_09_15_to_09_30' => 'Time 09 15 To 09 30',
            'time_09_30_to_09_45' => 'Time 09 30 To 09 45',
            'time_09_45_to_10_00' => 'Time 09 45 To 10 00',
            'time_10_00_to_10_15' => 'Time 10 00 To 10 15',
            'time_10_15_to_10_30' => 'Time 10 15 To 10 30',
            'time_10_30_to_10_45' => 'Time 10 30 To 10 45',
            'time_10_45_to_11_00' => 'Time 10 45 To 11 00',
            'time_11_00_to_11_15' => 'Time 11 00 To 11 15',
            'time_11_15_to_11_30' => 'Time 11 15 To 11 30',
            'time_11_30_to_11_45' => 'Time 11 30 To 11 45',
            'time_11_45_to_12_00' => 'Time 11 45 To 12 00',
            'time_12_00_to_12_15' => 'Time 12 00 To 12 15',
            'time_12_15_to_12_30' => 'Time 12 15 To 12 30',
            'time_12_30_to_12_45' => 'Time 12 30 To 12 45',
            'time_12_45_to_13_00' => 'Time 12 45 To 13 00',
            'time_13_00_to_13_15' => 'Time 13 00 To 13 15',
            'time_13_15_to_13_30' => 'Time 13 15 To 13 30',
            'time_13_30_to_13_45' => 'Time 13 30 To 13 45',
            'time_13_45_to_14_00' => 'Time 13 45 To 14 00',
            'time_14_00_to_14_15' => 'Time 14 00 To 14 15',
            'time_14_15_to_14_30' => 'Time 14 15 To 14 30',
            'time_14_30_to_14_45' => 'Time 14 30 To 14 45',
            'time_14_45_to_15_00' => 'Time 14 45 To 15 00',
            'time_15_00_to_15_15' => 'Time 15 00 To 15 15',
            'time_15_15_to_15_30' => 'Time 15 15 To 15 30',
            'time_15_30_to_15_45' => 'Time 15 30 To 15 45',
            'time_15_45_to_16_00' => 'Time 15 45 To 16 00',
            'time_16_00_to_16_15' => 'Time 16 00 To 16 15',
            'time_16_15_to_16_30' => 'Time 16 15 To 16 30',
            'time_16_30_to_16_45' => 'Time 16 30 To 16 45',
            'time_16_45_to_17_00' => 'Time 16 45 To 17 00',
            'is_active' => 'Is Active',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getRoute($params)
    {
        $data = NULL;
        $route = array();
        if (!empty($params['route'])) {
            if ($params['route'] == "link-staff-subject-view") {

                $route[] = '/link-staff-subject';
                $route[] = 'view';

                $data['id'] = $this->id;
            } else if ($params['route'] == "link-staff-subject-update") {

                $route[] = '/link-staff-subject';
                $route[] = 'update';

                $data['id'] = $this->id;
            } else if ($params['route'] == "link-staff-subject-delete") {

                $route[] = '/link-staff-subject';
                $route[] = 'delete';

                $data['id'] = $this->id;
            } else if ($params['route'] == "link-staff-subject-create") {

                $route[] = '/link-staff-subject';
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

        $scenarios[self::SCENARIO_CREATE_LINK] = ['user_id', 'subject_id', 'day_id', 'time_09_00_to_09_15', 'time_09_15_to_09_30', 'time_09_30_to_09_45', 'time_09_45_to_10_00', 'time_10_00_to_10_15', 'time_10_15_to_10_30', 'time_10_30_to_10_45', 'time_10_45_to_11_00', 'time_11_00_to_11_15', 'time_11_15_to_11_30', 'time_11_30_to_11_45', 'time_11_45_to_12_00', 'time_12_00_to_12_15', 'time_12_15_to_12_30', 'time_12_30_to_12_45', 'time_12_45_to_13_00', 'time_13_00_to_13_15', 'time_13_15_to_13_30', 'time_13_30_to_13_45', 'time_13_45_to_14_00', 'time_14_00_to_14_15', 'time_14_15_to_14_30', 'time_14_30_to_14_45', 'time_14_45_to_15_00', 'time_15_00_to_15_15', 'time_15_15_to_15_30', 'time_15_30_to_15_45', 'time_15_45_to_16_00', 'time_16_00_to_16_15', 'time_16_15_to_16_30', 'time_16_30_to_16_45', 'time_16_45_to_17_00', 'is_active'];
        $scenarios[self::SCENARIO_UPDATE_LINK] = ['time_09_00_to_09_15', 'time_09_15_to_09_30', 'time_09_30_to_09_45', 'time_09_45_to_10_00', 'time_10_00_to_10_15', 'time_10_15_to_10_30', 'time_10_30_to_10_45', 'time_10_45_to_11_00', 'time_11_00_to_11_15', 'time_11_15_to_11_30', 'time_11_30_to_11_45', 'time_11_45_to_12_00', 'time_12_00_to_12_15', 'time_12_15_to_12_30', 'time_12_30_to_12_45', 'time_12_45_to_13_00', 'time_13_00_to_13_15', 'time_13_15_to_13_30', 'time_13_30_to_13_45', 'time_13_45_to_14_00', 'time_14_00_to_14_15', 'time_14_15_to_14_30', 'time_14_30_to_14_45', 'time_14_45_to_15_00', 'time_15_00_to_15_15', 'time_15_15_to_15_30', 'time_15_30_to_15_45', 'time_15_45_to_16_00', 'time_16_00_to_16_15', 'time_16_15_to_16_30', 'time_16_30_to_16_45', 'time_16_45_to_17_00', 'is_active'];

        return $scenarios;
    }
    public function beforeSave($insert)
    {
        if($insert){
            # if the save process is for inserting a new record
            $this->date_created = \common\models\System::getDateTime();
        } else {
            # else, the save process is for an update
            $this->date_updated = \common\models\System::getDateTime();
        }
        return true;
    }

    public function processInputData($params = NULL)
    {
        if($this->scenario == self::SCENARIO_CREATE_LINK){
            $this->creator_id=$params['user']->id;
            $this->alias = str_replace(' ','-',strtolower($this->title));
            if ($this->validate() && $this->save()) {
                return true;
            }
        }else if($this->scenario == self::SCENARIO_UPDATE_LINK){
            $this->updater_id=$params['user']->id;
            if ($this->validate() && $this->save()) {
                return true;
            }
        }
        return false;
    }
}
