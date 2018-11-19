<?php

namespace common\models\search;

use common\models\ActivityDuration;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActivityDurationSearch represents the model behind the search form about `common\models\ActivityDuration`.
 */
class ActivityDurationSearch extends ActivityDuration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'duration_id'], 'integer'],
            [['',], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = ActivityDuration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'duration_id' => $this->duration_id,
        ]);

        return $dataProvider;
    }
}
