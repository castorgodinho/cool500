<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_plot".
 *
 * @property integer $company_id
 * @property integer $plot_id
 * @property string $start_date
 *
 * @property Company $company
 * @property Plot $plot
 */
class CompanyPlot extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'company_plot';
    }


    public function rules()
    {
        return [
            [['company_id', 'plot_id', 'start_date'], 'required'],
            [['company_id', 'plot_id'], 'integer'],
            [['start_date'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['plot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plot::className(), 'targetAttribute' => ['plot_id' => 'plot_id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'plot_id' => 'Plot ID',
            'start_date' => 'Start Date',
        ];
    }


    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
    }


    public function getPlot()
    {
        return $this->hasOne(Plot::className(), ['plot_id' => 'plot_id']);
    }
}
