<?php

namespace common\models\search;

use common\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','activity_listing_id','order_status_id', 'customer_id'], 'integer'],
            [['start_date'], 'datetime', 'format' => 'php:Y-m-d H:s:i'],
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
        $query = Order::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'activity_listing_id' => $this->activity_listing_id,
            'order_status_id' => $this->order_status_id,
            'customer_id' => $this->customer_id,
        ]);
        $query->andFilterWhere($this->getDateTimeFilter('start_date'));

        return $dataProvider;
    }
}
