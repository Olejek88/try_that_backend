<?php

namespace common\models\search;

use common\models\Luminary;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LuminarySearch represents the model behind the search form about `common\models\Luminary`.
 */
class LuminarySearch extends Luminary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'verified', 'user_id'], 'integer'],
            [['verified_date',], 'string'],
            [['rating',], 'double'],
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
        $query = Luminary::find();

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
            'verified' => $this->verified,
            'rating' => $this->rating,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'verified_date', $this->verified_date]);

        return $dataProvider;
    }
}
