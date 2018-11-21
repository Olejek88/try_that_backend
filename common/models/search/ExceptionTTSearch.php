<?php

namespace common\models\search;

use common\models\ExceptionTT;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ExceptionTTSearch represents the model behind the search form about `common\models\ExceptionTT`.
 */
class ExceptionTTSearch extends ExceptionTT
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'luminary_id'], 'integer'],
            [['date',], 'string'],
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
        $query = ExceptionTT::find();
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
            'luminary_id' => $this->luminary_id,
        ]);
        $query->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }
}
