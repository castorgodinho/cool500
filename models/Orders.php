<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $order_id
 * @property integer $company_id
 * @property integer $plot_id
 * @property integer $built_area
 * @property integer $shed_area
 * @property integer $godown_area
 * @property string $start_date
 * @property string $end_date
 *
 * @property Company $company
 * @property Plot $plot
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'plot_id', 'built_area', 'shed_area', 'godown_area', 'start_date'], 'required'],
            [['company_id', 'plot_id', 'built_area', 'shed_area', 'godown_area'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['plot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plot::className(), 'targetAttribute' => ['plot_id' => 'plot_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'company_id' => 'Company ID',
            'plot_id' => 'Plot ID',
            'built_area' => 'Built Area',
            'shed_area' => 'Shed Area',
            'godown_area' => 'Godown Area',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlot()
    {
        return $this->hasOne(Plot::className(), ['plot_id' => 'plot_id']);
    }
}
