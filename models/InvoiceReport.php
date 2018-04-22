<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * SearchInvoice represents the model behind the search form of `app\models\Invoice`.
 */
class InvoiceReport extends Invoice
{
    /**
     * @inheritdoc
     */
    public $from_date;
    public $to_date;
    public $invoice_code;
    public function rules()
    {
        return [
            [['invoice_id', 'rate_id', 'invoice_code', 'tax_id', 'order_id', 'interest_id', 'total_amount'], 'integer'],
            [['start_date', 'from_date', 'to_date'], 'safe'],
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
        $query = Invoice::find();

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
        if($this->to_date == ''){
            $this->to_date = ("Y-m-d");
        }
        if($this->from_date == $this->to_date){
            $this->start_date = $this->from_date;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'invoice_id' => $this->invoice_id,
            'rate_id' => $this->rate_id,
            'tax_id' => $this->tax_id,
            'order_id' => $this->order_id,
            'interest_id' => $this->interest_id,
            'start_date' => $this->start_date,
            'total_amount' => $this->total_amount,
        ]);
        if($this->from_date != $this->to_date){
            $query->andFilterWhere(['between', 'start_date', $this->from_date, $this->to_date ]);
        }
       
        $query->orderBy(['invoice_id' => SORT_DESC]);

        return $dataProvider;
    }

    
}
