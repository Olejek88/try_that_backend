<?php

namespace common\models\search;

use common\models\ActivityImage;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActivityImageSearch represents the model behind the search form about `common\models\ActivityImage`.
 */
class ActivityImageSearch extends ActivityImage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'image_id'], 'integer'],
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
        $query = ActivityImage::find();
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
            'activity_id' => $this->id,
            'image_id' => $this->id,
        ]);

        return $dataProvider;
    }
}
