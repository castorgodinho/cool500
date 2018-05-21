<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice;

/**
 * SearchInvoice represents the model behind the search form of `app\models\Invoice`.
 */
class SearchInvoice extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'tax_id',  'interest_id', 'total_amount'], 'integer'],
            [['order_id', 'invoice_code'], 'safe'],
            [['start_date'], 'safe'],
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
        $query->joinWith(['order', 'company']);
        // grid filtering conditions
        $query->andFilterWhere([
            'tax_id' => $this->tax_id,
            'interest_id' => $this->interest_id,
            'start_date' => $this->start_date,
            'total_amount' => $this->total_amount,
        ]);



        $query->andFilterWhere(['like', 'invoice_code' , $this->invoice_code])
        ->orFilterWhere(['like', 'company.name', $this->order_id]);

        $query->andWhere(['flag' => '1']);
        $query->orderBy(['invoice_id' => SORT_DESC]);

        return $dataProvider;
    }
}
