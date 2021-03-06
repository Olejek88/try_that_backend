<?php

namespace common\models\search;

use common\models\OrderStatus;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderStatusSearch represents the model behind the search form about `common\models\OrderStatus`.
 */
class OrderStatusSearch extends OrderStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'string'],
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
        $query = OrderStatus::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id,]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
