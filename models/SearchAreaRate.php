<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AreaRate;

/**
 * SearchAreaRate represents the model behind the search form of `app\models\AreaRate`.
 */
class SearchAreaRate extends AreaRate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_rate_id', 'rate'], 'integer'],
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
        $query = AreaRate::find();

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
            'area_rate_id' => $this->area_rate_id,
            'rate' => $this->rate,
            'start_date' => $this->start_date,
        ]);

        return $dataProvider;
    }
}
