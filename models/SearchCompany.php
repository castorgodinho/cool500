<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Company;

/**
 * SearchCompany represents the model behind the search form about `app\models\Company`.
 */
class SearchCompany extends Company
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'company_id'], 'integer'],
            [['name','user_id', 'address', 'constitution', 'products', 'gstin', 'owner_name', 'owner_phone', 'owner_mobile', 'competent_name', 'competent_email', 'competent_mobile'], 'safe'],
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
        $query = Company::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'company_id' => SORT_DESC,
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
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'constitution', $this->constitution])
            ->andFilterWhere(['like', 'products', $this->products])
            ->andFilterWhere(['like', 'gstin', $this->gstin])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'owner_phone', $this->owner_phone])
            ->andFilterWhere(['like', 'owner_mobile', $this->owner_mobile])
            ->andFilterWhere(['like', 'competent_name', $this->competent_name])
            ->andFilterWhere(['like', 'competent_email', $this->competent_email])
            ->andFilterWhere(['like', 'competent_mobile', $this->competent_mobile]);

        return $dataProvider;
    }
}
