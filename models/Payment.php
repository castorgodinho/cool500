<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $payment_id
 * @property int $order_id
 * @property int $amount
 * @property string $start_date
 * @property string $mode
 * @property int $invoice_id
 * @property int $tds_rate
 * @property int $tds_amount
 * @property int $balance_amount
 * @property string $payment_no
 * @property int $penal
 * @property string $cheque_no
 * @property int $lease_rent
 * @property int $tax
 * @property int $status
 *
 * @property Debit[] $debits
 * @property Invoice $invoice
 * @property Orders $order
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */


    public $file;
    public $penalInterestAmount;

    public function rules()
    {
        return [
            [['order_id', 'amount', 'invoice_id', 'balance_amount', 'penal', 'lease_rent', 'tax'], 'integer'],
            [['start_date', 'tds_file', 'transaction_no', 'transaction_details','tds_rate', 'tds_amount','cheque_no'], 'safe'],
            [['file'], 'file'],
            [['balance_amount', 'payment_no', 'penal',  'lease_rent', 'tax','mode','amount'], 'required'],
            [['mode'], 'string', 'max' => 50],
            [['payment_no', 'cheque_no'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 4],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'invoice_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Receipt ID',
            'order_id' => 'Order ID',
            'amount' => 'Amount',
            'start_date' => 'Start Date',
            'mode' => 'Mode',
            'invoice_id' => 'Invoice ID',
            'tds_rate' => 'Tds Rate',
            'tds_amount' => 'Tds Amount',
            'balance_amount' => 'Balance Amount',
            'payment_no' => 'Receipt No',
            'penal' => 'Penal',
            'cheque_no' => 'Cheque No',
            'lease_rent' => 'Lease Rent',
            'tax' => 'Tax',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebits()
    {
        return $this->hasMany(Debit::className(), ['payment_id' => 'payment_id']);
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
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['order_id' => 'order_id']);
    }
}
