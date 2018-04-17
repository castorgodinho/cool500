<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tax;

/**
 * SearchTax represents the model behind the search form about `app\models\Tax`.
 */
class SearchTax extends Tax
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tax_id', 'rate'], 'integer'],
            [['name', 'date'], 'safe'],
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
        $query = Tax::find();

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
            'tax_id' => $this->tax_id,
            'rate' => $this->rate,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->orderBy(['flag' => SORT_DESC  ]);

        return $dataProvider;
    }
}
