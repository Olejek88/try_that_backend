<?php

namespace common\models\search;

use common\models\NewsImage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * NewsImageSearch represents the model behind the search form about `common\models\NewsImage`.
 */
class NewsImageSearch extends NewsImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'news_id', 'image_id'], 'integer'],
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
        $query = NewsImage::find();

        // add conditions that should always apply here

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
            'news_id' => $this->news_id,
            'image_id' => $this->image_id,
        ]);

        return $dataProvider;
    }
}
