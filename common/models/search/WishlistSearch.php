<?php

namespace common\models\search;

use common\models\Wishlist;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WishlistSearch represents the model behind the search form about `common\models\Wishlist`.
 */
class WishlistSearch extends Wishlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'customer_id'], 'integer'],
            [['date'], 'string'],
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
        $query = Wishlist::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'customer_id' => $this->customer_id,
        ]);
        $query->andFilterWhere($this->getDateTimeFilter('date'));

        return $dataProvider;
    }
}
