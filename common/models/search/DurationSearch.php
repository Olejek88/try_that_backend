<?php

namespace common\models\search;

use common\models\Duration;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DurationSearch represents the model behind the search form about `common\models\Duration`.
 */
class DurationSearch extends Duration
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'luminary_id'], 'integer'],
            [['duration'], 'string'],
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
        $query = Duration::find();
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
            'luminary_id' => $this->luminary_id,
        ]);
        $query->andFilterWhere(['like', 'duration', $this->duration]);

        return $dataProvider;
    }
}
