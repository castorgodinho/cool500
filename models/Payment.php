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
 * @property int $tax
 * @property int $lease_rent
 *
 * @property Invoice $invoice
 * @property Orders $order
 */
class Payment extends \yii\db\ActiveRecord
{
  public $file;
  public $lease_rent;
  public $penalInterestAmount;

    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'amount', 'invoice_id', 'tds_rate', 'tds_amount', 'balance_amount', 'penal', 'tax', 'lease_rent'], 'integer'],
            [['start_date', 'lease_rent', 'file'], 'safe'],
            [['file'], 'file'],
            [['penalInterestAmount'], 'safe'],
            [['balance_amount', 'payment_no', 'penal', 'cheque_no', 'tax', 'lease_rent'], 'required'],
            [['mode'], 'string', 'max' => 50],
            [['payment_no', 'cheque_no'], 'string', 'max' => 100],
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
            'payment_id' => 'Payment ID',
            'order_id' => 'Order ID',
            'amount' => 'Amount',
            'start_date' => 'Start Date',
            'mode' => 'Mode',
            'invoice_id' => 'Invoice ID',
            'tds_rate' => 'Tds Rate',
            'tds_amount' => 'Tds Amount',
            'balance_amount' => 'Balance Amount',
            'payment_no' => 'Payment No',
            'penal' => 'Penal',
            'cheque_no' => 'Cheque No',
            'tax' => 'Tax',
            'lease_rent' => 'Lease Rent',
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
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['order_id' => 'order_id']);
    }
}
