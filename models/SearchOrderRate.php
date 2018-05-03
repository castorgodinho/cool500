<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderRate;

/**
 * SearchOrderRate represents the model behind the search form of `app\models\OrderRate`.
 */
class SearchOrderRate extends OrderRate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_rate_id', 'amount1', 'amount2'], 'integer'],
            [['start_date', 'end_date', 'flag', 'order_id'], 'safe'],
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
        $query = OrderRate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('order');

        // grid filtering conditions
        $query->andFilterWhere([
            'order_rate_id' => $this->order_rate_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount1' => $this->amount1,
            'amount2' => $this->amount2,
        ]);

        $query->andFilterWhere(['like', 'flag', $this->flag]);
        $query->andFilterWhere(['like', 'orders.order_number', $this->order_id]);

        return $dataProvider;
    }
}
