<?php

namespace common\models\search;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'city_id', 'country_id'], 'integer'],
            [['username', 'email', 'firstName', 'lastName', 'phone'], 'string'],
            [['birthDate', 'registeredDate'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
        ]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'firstName', $this->firstName]);
        $query->andFilterWhere(['like', 'lastName', $this->lastName]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere($this->getDateTimeFilter('birthDate'));
        $query->andFilterWhere($this->getDateTimeFilter('registeredDate'));

        return $dataProvider;
    }
}
