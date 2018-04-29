<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $invoice_id
 * @property int $rate_id
 * @property int $tax_id
 * @property int $order_id
 * @property int $interest_id
 * @property string $start_date
 * @property int $total_amount
 * @property string $invoice_code
 * @property int $prev_lease_rent
 * @property int $grand_total
 * @property int $prev_tax
 * @property int $prev_interest
 * @property int $prev_dues_total
 * @property int $current_lease_rent
 * @property int $current_tax
 * @property int $current_interest
 * @property int $current_dues_total
 * @property int $current_total_dues
 *
 * @property Interest $interest
 * @property Orders $order
 * @property Rate $rate
 * @property Tax $tax
 * @property Payment[] $payments
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate_id', 'tax_id', 'interest_id', 'prev_lease_rent', 'grand_total', 'prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_interest', 'current_total_dues'], 'integer'],
            [['start_date' ,'order_id'], 'safe'],
            [['invoice_code', 'prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_interest', 'current_total_dues'], 'required'],
            [['invoice_code'], 'string', 'max' => 100],
            [['interest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interest::className(), 'targetAttribute' => ['interest_id' => 'interest_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'order_id']],
            [['rate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rate::className(), 'targetAttribute' => ['rate_id' => 'rate_id']],
            [['tax_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tax::className(), 'targetAttribute' => ['tax_id' => 'tax_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'rate_id' => 'Lease Rate',
            'tax_id' => 'Tax',
            'order_id' => 'Unit No',
            'interest_id' => 'Penal Interest',
            'start_date' => 'Invoice Date',
            'total_amount' => 'Total Amount',
            'invoice_code' => 'Invoice No.',
            'prev_lease_rent' => 'Previous Lease Rent (INR) ',
            'grand_total' => 'Grand Total',
            'prev_tax' => 'Previous Tax Total (INR)',
            'prev_interest' => 'Previous Interest (INR)',
            'prev_dues_total' => 'Previous Dues Total (A) (INR)',
            'current_lease_rent' => 'Current Lease Rent (INR)',
            'current_tax' => 'Current Tax Total (INR)',
            'current_interest' => 'Current Interest (INR)',
            'current_dues_total' => 'hello',
            'current_total_dues' => 'Current Total Dues (B) (INR)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(Interest::className(), ['interest_id' => 'interest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['rate_id' => 'rate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['tax_id' => 'tax_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['invoice_id' => 'invoice_id']);
    }
}
