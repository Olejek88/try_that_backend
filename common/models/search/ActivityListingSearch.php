<?php

namespace common\models\search;

use common\models\ActivityListing;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActivityListingSearch represents the model behind the search form about `common\models\ActivityListing`.
 */
class ActivityListingSearch extends ActivityListing
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'duration_id', 'currency_id', 'is_group'], 'integer'],
            [['cost'], 'double'],
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
        $query = ActivityListing::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere($this->getNumericFilter('cost'));
        $query->andFilterWhere([
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'duration_id' => $this->duration_id,
            'currency_id' => $this->currency_id,
            'is_group' => $this->is_group,
        ]);

        return $dataProvider;
    }
}
