<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Interest;

/**
 * SearchInterest represents the model behind the search form of `app\models\Interest`.
 */
class SearchInterest extends Interest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interest_id', 'rate'], 'integer'],
            [['name', 'type', 'start_date'], 'safe'],
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
        $query = Interest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,'sort' => [
                'defaultOrder' => [
                    'interest_id' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'interest_id' => $this->interest_id,
            'rate' => $this->rate,
            'start_date' => $this->start_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type]);

        $query->orderBy(['flag' => SORT_DESC  ]);

        return $dataProvider;
    }
}
