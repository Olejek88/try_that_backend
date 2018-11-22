<?php

namespace common\models\search;

use common\models\Activity;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActivitySearch represents the model behind the search form about `common\models\Activity`.
 */
class ActivitySearch extends Activity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'luminary_id',
                    'category_id',
                    'activity_category_id',
                    'min_customers',
                    'max_customers',
                ],
                'integer'
            ],
            [['title', 'description'], 'string'],
            [['start_date', 'end_date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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
        $query = Activity::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'luminary_id' => $this->luminary_id,
            'category_id' => $this->category_id,
            'activity_category_id' => $this->activity_category_id,
            'min_customers' => $this->min_customers,
            'max_customers' => $this->max_customers,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere($this->getDateTimeFilter('start_date'));
        $query->andFilterWhere($this->getDateTimeFilter('end_date'));

        return $dataProvider;
    }
}
