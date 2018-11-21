<?php

namespace common\models\search;

use common\models\ActivityTag;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActivityTagSearch represents the model behind the search form about `common\models\ActivityTag`.
 */
class ActivityTagSearch extends ActivityTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'tag_id'], 'integer'],
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
        $query = ActivityTag::find();
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
            'activity_id' => $this->activity_id,
            'tag_id' => $this->tag_id,
        ]);

        return $dataProvider;
    }
}
