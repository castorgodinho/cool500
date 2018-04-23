<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;

/**
 * SearchPayment represents the model behind the search form of `app\models\Payment`.
 */
class SearchPayment extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'amount', ], 'integer'],
            [['start_date', 'mode', 'invoice_id'], 'safe'],
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
        $query = Payment::find();

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

        $query->joinWith('invoice');

        // grid filtering conditions
        $query->andFilterWhere([
            'payment_id' => $this->payment_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
        ]);

        $query->andFilterWhere(['like', 'mode', $this->mode]);
        $query->andFilterWhere(['like', 'invoice.invoice_code', $this->invoice_id]);

        $query->orderBy(['payment_id' => SORT_DESC]);

        return $dataProvider;
    }
}
