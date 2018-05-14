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
 * @property string $due_date
 *
 * @property Debit[] $debits
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
            [['rate_id', 'tax_id', 'order_id', 'interest_id', 'total_amount', 'prev_lease_rent', 'grand_total', 'prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_interest', 'current_dues_total', 'current_total_dues'], 'integer'],
            [['start_date', 'email_status', 'lease_current_start', 'lease_prev_start'], 'safe'],
            [['invoice_code', 'prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_interest', 'current_dues_total', 'current_total_dues', 'due_date'], 'required'],
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
            'rate_id' => 'Rate ID',
            'tax_id' => 'Tax ID',
            'order_id' => 'Order ID',
            'interest_id' => 'Interest ID',
            'start_date' => 'Start Date',
            'total_amount' => 'Total Amount',
            'invoice_code' => 'Invoice Code',
            'prev_lease_rent' => 'Prev Lease Rent',
            'grand_total' => 'Grand Total',
            'prev_tax' => 'Prev Tax',
            'prev_interest' => 'Prev Interest',
            'prev_dues_total' => 'Prev Dues Total',
            'current_lease_rent' => 'Current Lease Rent',
            'current_tax' => 'Current Tax',
            'current_interest' => 'Current Interest',
            'current_dues_total' => 'Current Dues Total',
            'current_total_dues' => 'Current Total Dues',
            'due_date' => 'Due Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebits()
    {
        return $this->hasMany(Debit::className(), ['invoice_id' => 'invoice_id']);
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

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id'])->via('order');
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
