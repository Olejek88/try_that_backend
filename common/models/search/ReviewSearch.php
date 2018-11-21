<?php

namespace common\models\search;

use common\models\Review;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ReviewSearch represents the model behind the search form about `common\models\Review`.
 */
class ReviewSearch extends Review
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'customer_id', 'rate'], 'integer'],
            [['description'], 'string'],
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
        $query = Review::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'customer_id' => $this->customer_id,
        ]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere($this->getNumericFilter('rate'));

        return $dataProvider;
    }
}
