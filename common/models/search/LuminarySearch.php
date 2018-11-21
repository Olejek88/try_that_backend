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
            [['verified_date',], 'datetime', 'format' => 'php:Y-m-d H:s:i'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere($this->getNumericFilter('rating'));
        $query->andFilterWhere([
            'id' => $this->id,
            'verified' => $this->verified,
            'user_id' => $this->user_id,
        ]);
        $query->andFilterWhere($this->getDateTimeFilter('verified_date'));

        return $dataProvider;
    }
}
