<?php

namespace common\models\search;

use common\models\GroupExperience;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GroupExperienceSearch represents the model behind the search form about `common\models\GroupExperience`.
 */
class GroupExperienceSearch extends GroupExperience
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_listing_id', 'customer_id'], 'integer'],
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
        $query = GroupExperience::find();
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
            'activity_listing_id' => $this->activity_listing_id,
            'customer_id' => $this->customer_id,
        ]);

        return $dataProvider;
    }
}
