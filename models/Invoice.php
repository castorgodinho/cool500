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
            [['rate_id', 'tax_id', 'order_id', 'interest_id', 'total_amount'], 'integer'],
            [['start_date','invoice_code'], 'safe'],
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
