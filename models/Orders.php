<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $order_id
 * @property string $order_number
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

    public $area_id;
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
            [['order_number', 'company_id', 'plot_id', 'built_area', 'shed_area', 'godown_area', 'start_date'], 'required'],
            [['company_id', 'plot_id', 'built_area', 'shed_area', 'godown_area'], 'integer'],
            [['start_date', 'end_date', 'area_id'], 'safe'],
            [['order_number'], 'string', 'max' => 20],
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
            'Order Number' => 'Order Number',
            'Company Name' => 'Company ID',
            'Plot No' => 'Plot ID',
            'Built Area' => 'Built Area',
            'Shed Area' => 'Shed Area',
            'Godown Area' => 'Godown Area',
            'Allotment Date' => 'Start Date',
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
