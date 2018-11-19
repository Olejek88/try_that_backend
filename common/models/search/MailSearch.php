<?php

namespace common\models\search;

use common\models\Mail;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MailSearch represents the model behind the search form about `common\models\Mail`.
 */
class MailSearch extends Mail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['id', 'order_id', 'from_user_id', 'to_user_id', 'status_id', 'activity_id', 'send_date', 'read_date'],
                'integer'
            ],
            [['title', 'text',], 'string'],
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
        $query = Mail::find();

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
            'order_id' => $this->order_id,
            'from_user_id' => $this->from_user_id,
            'to_user_id' => $this->to_user_id,
            'status_id' => $this->status_id,
            'activity_id' => $this->activity_id,
            'send_date' => $this->send_date,
            'read_date' => $this->read_date,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
