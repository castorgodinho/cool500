<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * SearchOrders represents the model behind the search form about `app\models\Orders`.
 */
class SearchOrders extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'company_id', 'plot_id', 'built_area', 'shed_area', 'godown_area'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
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
        
        $query = Orders::find()->groupBy('company_id')/* ->select(['company_id', 'start_date'])->distinct() */;
        /* $query = Orders::find()->where(['in', 'company_id', $orderList->company_id ])->all(); */
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

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'company_id' => $this->company_id,
            'plot_id' => $this->plot_id,
            'built_area' => $this->built_area,
            'shed_area' => $this->shed_area,
            'godown_area' => $this->godown_area,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        return $dataProvider;
    }
}
