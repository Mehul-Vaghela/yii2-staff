<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Subject;

/**
 * SubjectSearch represents the model behind the search form of `backend\models\Subject`.
 */
class SubjectSearch extends Subject
{
    public $creator_string;
    public $updater_string;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id', 'is_active'], 'integer'],
            [['title',
                'creator_string',
                'updater_string',
                'alias', 'date_created', 'date_updated'], 'safe'],
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
        $query = Subject::find()
            ->joinWith('creator as creator_t')
            ->joinWith('updater as updater_t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['creator_string'] = [
            'asc' => ["CONCAT(creator_t.firstname,' ',creator_t.lastname)" => SORT_ASC],
            'desc' => ["CONCAT(creator_t.firstname,' ',creator_t.lastname)" => SORT_DESC]
        ];

        $dataProvider->sort->attributes['updater_string'] = [
            'asc' => ["CONCAT(updater_t.firstname,' ',updater_t.lastname)" => SORT_ASC],
            'desc' => ["CONCAT(updater_t.firstname,' ',updater_t.lastname)" => SORT_DESC]
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'is_active' => $this->is_active,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated,
        ]);
        $query->andFilterWhere(['like', "CONCAT(creator_t.firstname,' ',creator_t.lastname)", $this->creator_string]);
        $query->andFilterWhere(['like', "CONCAT(updater_t.firstname,' ',updater_t.lastname)", $this->updater_string]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
