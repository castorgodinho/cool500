<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "debit".
 *
 * @property int $debit_id
 * @property int $penal
 * @property int $invoice_id
 * @property int $payment_id
 * @property string $start_date
 * @property int $order_id
 *
 * @property Invoice $invoice
 * @property Payment $payment
 * @property Orders $order
 */
class Debit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['penal'], 'required'],
            [['penal', 'invoice_id', 'payment_id', 'order_id'], 'integer'],
            [['start_date'], 'safe'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'invoice_id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['payment_id' => 'payment_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'debit_id' => 'Debit ID',
            'penal' => 'Penal',
            'invoice_id' => 'Invoice ID',
            'payment_id' => 'Payment ID',
            'start_date' => 'Start Date',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['payment_id' => 'payment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['order_id' => 'order_id']);
    }
}
