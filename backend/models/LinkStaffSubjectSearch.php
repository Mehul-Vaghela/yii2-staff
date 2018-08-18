<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\LinkStaffSubject;

/**
 * LinkStaffSubjectSearch represents the model behind the search form of `backend\models\LinkStaffSubject`.
 */
class LinkStaffSubjectSearch extends LinkStaffSubject
{
    public $is_admin;
    public $staff_id;
    public $user_string;
    public $subject_string;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'subject_id', 'day_id', 'time_09_00_to_09_15', 'time_09_15_to_09_30', 'time_09_30_to_09_45', 'time_09_45_to_10_00', 'time_10_00_to_10_15', 'time_10_15_to_10_30', 'time_10_30_to_10_45', 'time_10_45_to_11_00', 'time_11_00_to_11_15', 'time_11_15_to_11_30', 'time_11_30_to_11_45', 'time_11_45_to_12_00', 'time_12_00_to_12_15', 'time_12_15_to_12_30', 'time_12_30_to_12_45', 'time_12_45_to_13_00', 'time_13_00_to_13_15', 'time_13_15_to_13_30', 'time_13_30_to_13_45', 'time_13_45_to_14_00', 'time_14_00_to_14_15', 'time_14_15_to_14_30', 'time_14_30_to_14_45', 'time_14_45_to_15_00', 'time_15_00_to_15_15', 'time_15_15_to_15_30', 'time_15_30_to_15_45', 'time_15_45_to_16_00', 'time_16_00_to_16_15', 'time_16_15_to_16_30', 'time_16_30_to_16_45', 'time_16_45_to_17_00', 'is_active'], 'integer'],
            [['date_created','user_string','is_admin','staff_id','subject_string', 'date_updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LinkStaffSubject::find()
            ->joinWith('user as user_t')
            ->joinWith('subject as subject_t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['user_string'] = [
            'asc' => ["CONCAT(user_t.firstname,' ',user_t.lastname)" => SORT_ASC],
            'desc' => ["CONCAT(user_t.firstname,' ',user_t.lastname)" => SORT_DESC]
        ];
        $dataProvider->sort->attributes['subject_string'] = [
            'asc' => ["subject_t.title" => SORT_ASC],
            'desc' => ["subject_t.title" => SORT_DESC]
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', "CONCAT(user_t.firstname,' ',user_t.lastname)", $this->user_string]);
        $query->andFilterWhere(['like', "subject_t.title", $this->subject_string]);

        if(!$this->is_admin){
            $query->andFilterWhere(['user_t.id'=>$this->staff_id]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'user_id' => $this->user_id,
//            'subject_id' => $this->subject_id,
            'day_id' => $this->day_id,
            'time_09_00_to_09_15' => $this->time_09_00_to_09_15,
            'time_09_15_to_09_30' => $this->time_09_15_to_09_30,
            'time_09_30_to_09_45' => $this->time_09_30_to_09_45,
            'time_09_45_to_10_00' => $this->time_09_45_to_10_00,
            'time_10_00_to_10_15' => $this->time_10_00_to_10_15,
            'time_10_15_to_10_30' => $this->time_10_15_to_10_30,
            'time_10_30_to_10_45' => $this->time_10_30_to_10_45,
            'time_10_45_to_11_00' => $this->time_10_45_to_11_00,
            'time_11_00_to_11_15' => $this->time_11_00_to_11_15,
            'time_11_15_to_11_30' => $this->time_11_15_to_11_30,
            'time_11_30_to_11_45' => $this->time_11_30_to_11_45,
            'time_11_45_to_12_00' => $this->time_11_45_to_12_00,
            'time_12_00_to_12_15' => $this->time_12_00_to_12_15,
            'time_12_15_to_12_30' => $this->time_12_15_to_12_30,
            'time_12_30_to_12_45' => $this->time_12_30_to_12_45,
            'time_12_45_to_13_00' => $this->time_12_45_to_13_00,
            'time_13_00_to_13_15' => $this->time_13_00_to_13_15,
            'time_13_15_to_13_30' => $this->time_13_15_to_13_30,
            'time_13_30_to_13_45' => $this->time_13_30_to_13_45,
            'time_13_45_to_14_00' => $this->time_13_45_to_14_00,
            'time_14_00_to_14_15' => $this->time_14_00_to_14_15,
            'time_14_15_to_14_30' => $this->time_14_15_to_14_30,
            'time_14_30_to_14_45' => $this->time_14_30_to_14_45,
            'time_14_45_to_15_00' => $this->time_14_45_to_15_00,
            'time_15_00_to_15_15' => $this->time_15_00_to_15_15,
            'time_15_15_to_15_30' => $this->time_15_15_to_15_30,
            'time_15_30_to_15_45' => $this->time_15_30_to_15_45,
            'time_15_45_to_16_00' => $this->time_15_45_to_16_00,
            'time_16_00_to_16_15' => $this->time_16_00_to_16_15,
            'time_16_15_to_16_30' => $this->time_16_15_to_16_30,
            'time_16_30_to_16_45' => $this->time_16_30_to_16_45,
            'time_16_45_to_17_00' => $this->time_16_45_to_17_00,
            'is_active' => $this->is_active,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ]);

        return $dataProvider;
    }
}
