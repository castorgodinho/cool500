<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rate;

/**
 * SearchRate represents the model behind the search form about `app\models\Rate`.
 */
class SearchRate extends Rate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate_id', 'area_id','extra', 'rate'], 'integer'],
            [['date'], 'safe'],
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
        $query = Rate::find();

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
            'rate_id' => $this->rate_id,
            'area_id' => $this->area_id,
            'rate' => $this->rate,
            'date' => $this->date,
        ]);

        $query->orderBy(['flag' => SORT_DESC  ]);

        return $dataProvider;
    }
}
