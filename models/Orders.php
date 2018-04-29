<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property string $order_number
 * @property int $company_id
 * @property int $built_area
 * @property int $shed_area
 * @property int $godown_area
 * @property string $start_date
 * @property string $end_date
 * @property int $shed_no
 * @property int $godown_no
 * @property int $area_id
 * @property int $total_area
 *
 * @property Invoice[] $invoices
 * @property OrderDetails[] $orderDetails
 * @property Plot[] $plots
 * @property Area $area
 * @property Company $company
 * @property Payment[] $payments
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
            [['order_number', 'company_id', 'total_area'], 'required'],
            [['company_id', 'built_area', 'shed_area', 'godown_area', 'shed_no', 'godown_no', 'area_id', 'total_area'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['order_number'], 'string', 'max' => 20],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'area_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Unit ID',
            'order_number' => 'Unit Number',
            'company_id' => 'Company ID',
            'built_area' => 'Built Area',
            'shed_area' => 'Shed Area',
            'godown_area' => 'Godown Area',
            'start_date' => 'Allotted Date',
            'end_date' => 'Renewal Date',
            'shed_no' => 'Shed No',
            'godown_no' => 'Godown No',
            'area_id' => 'Area ID',
            'total_area' => 'Total Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlots()
    {
        return $this->hasMany(Plot::className(), ['plot_id' => 'plot_id'])->viaTable('order_details', ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['area_id' => 'area_id']);
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
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['order_id' => 'order_id']);
    }
}
