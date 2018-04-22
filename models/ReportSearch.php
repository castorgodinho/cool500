<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Area;

/**
 * SearchArea represents the model behind the search form of `app\models\Area`.
 */
class ReportSearch extends Area
{
    /**
     * @inheritdoc
     */
    public $payment_id;
    public $start_date;
    public $order_id;
    public $amount;
    public $invoice_id;
    
    public function rules()
    {
        return [
            [['start_date', 'mode','payment_id', 'order_id', 'amount', 'invoice_id'], 'safe'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'payment_id' => $this->payment_id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'start_date' => $this->start_date,
            'invoice_id' => $this->invoice_id,
        ]);

        return $dataProvider;
    }
}
