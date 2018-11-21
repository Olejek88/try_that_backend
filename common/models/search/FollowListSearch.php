<?php

namespace common\models\search;

use common\models\FollowList;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FollowListSearch represents the model behind the search form about `common\models\FollowList`.
 */
class FollowListSearch extends FollowList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'luminary_id'], 'integer'],
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
        $query = FollowList::find();
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
            'customer_id' => $this->customer_id,
            'luminary_id' => $this->luminary_id,
        ]);

        return $dataProvider;
    }
}
