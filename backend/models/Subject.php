<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property string $id
 * @property string $creator_id
 * @property string $updater_id
 * @property string $title
 * @property string $alias
 * @property int $is_active
 * @property string $date_created
 * @property string $date_updated
 *
 * @property User $creator
 * @property User $updater
 */
class Subject extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE_SUBJECT = 'create-subject';
    const SCENARIO_UPDATE_SUBJECT = 'update-subject';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_id', 'updater_id', 'is_active'], 'integer'],
            [['title', 'alias'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['title'], 'string', 'max' => 128],
            [['alias'], 'string', 'max' => 256],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'title' => 'Subject Name',
            'alias' => 'Alias',
            'is_active' => 'Is Active',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    public function getRoute($params)
    {
        $data = NULL;
        $route = array();
        if (!empty($params['route'])) {
            if ($params['route'] == "subject-view") {

                $route[] = '/subject';
                $route[] = 'view';

                $data['id'] = $this->id;
            } else if ($params['route'] == "subject-update") {

                $route[] = '/subject';
                $route[] = 'update';

                $data['id'] = $this->id;
            } else if ($params['route'] == "subject-delete") {

                $route[] = '/subject';
                $route[] = 'delete';

                $data['id'] = $this->id;
            } else if ($params['route'] == "subject-create") {

                $route[] = '/subject';
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

        $scenarios[self::SCENARIO_CREATE_SUBJECT] = ['is_active','title'];
        $scenarios[self::SCENARIO_UPDATE_SUBJECT] = ['is_active','title'];

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
        if($this->scenario == self::SCENARIO_CREATE_SUBJECT){
            $this->creator_id=$params['user']->id;
            $this->alias = str_replace(' ','-',strtolower($this->title));
            if ($this->validate() && $this->save()) {
                return true;
            }
        }else if($this->scenario == self::SCENARIO_UPDATE_SUBJECT){
            $this->updater_id=$params['user']->id;
            if ($this->validate() && $this->save()) {
                return true;
            }
        }
        return false;
    }

}
