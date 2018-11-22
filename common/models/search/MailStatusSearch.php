<?php

namespace common\models\search;

use common\models\MailStatus;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MailStatusSearch represents the model behind the search form about `common\models\MailStatus`.
 */
class MailStatusSearch extends MailStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'string'],
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
        $query = MailStatus::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id,]);
        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
