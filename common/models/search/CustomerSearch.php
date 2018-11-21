<?php

namespace common\models\search;

use common\models\Customer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerSearch represents the model behind the search form about `common\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'positive', 'negative', 'active', 'user_id'], 'integer'],
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
        $query = Customer::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'user_id' => $this->user_id,
        ]);
        $query->andFilterWhere($this->getNumericFilter('positive'));
        $query->andFilterWhere($this->getNumericFilter('negative'));

        return $dataProvider;
    }
}
