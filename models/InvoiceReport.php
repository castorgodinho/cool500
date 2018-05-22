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
    public $search_key;
    public function rules()
    {
        return [
            [['invoice_id',  'tax_id', 'order_id', 'interest_id', 'total_amount'], 'integer'],
            [['start_date', 'from_date','invoice_code', 'to_date', 'search_key'], 'safe'],
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
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith(['order', 'company']);
        if($this->from_date == $this->to_date){
            $this->start_date = $this->from_date;
        }

        if($this->from_date != "" && $this->to_date != ""){
            if($this->from_date != $this->to_date){
                $query->andFilterWhere(['between', 'invoice.start_date', $this->from_date, $this->to_date ]);
            }
        }

        echo '=> '.$this->search_key;
        // grid filtering conditions
        $query->andFilterWhere(['like', 'invoice_code', $this->search_key])
         ->orFilterWhere(['like', 'orders.order_number', $this->search_key])
         ->orFilterWhere(['like', 'company.name', $this->search_key])
        /* ->andFilterWhere(['like', 'competent_mobile', $this->competent_mobile]) */;



        $query->orderBy(['invoice_id' => SORT_DESC]);

        return $dataProvider;
    }


}
