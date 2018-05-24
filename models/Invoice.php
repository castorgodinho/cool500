<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $invoice_id
 * @property int $tax_id
 * @property int $order_id
 * @property int $interest_id
 * @property string $start_date
 * @property int $prev_lease_rent
 * @property int $prev_tax
 * @property int $prev_interest
 * @property int $prev_dues_total
 * @property int $current_lease_rent
 * @property int $current_tax
 * @property int $current_dues_total
 * @property string $due_date
 * @property int $email_status
 * @property string $lease_current_start
 * @property string $lease_prev_start
 * @property int $total_amount
 * @property int $flag
 * @property string $invoice_code
 *
 * @property Debit[] $debits
 * @property Interest $interest
 * @property Orders $order
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
            [['tax_id', 'order_id', 'interest_id', 'prev_lease_rent', 'prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_dues_total', 'total_amount'], 'integer'],
            [['start_date', 'due_date', 'lease_current_start', 'lease_prev_start'], 'safe'],
            [['prev_tax', 'prev_interest', 'prev_dues_total', 'current_lease_rent', 'current_tax', 'current_dues_total', 'due_date', 'total_amount', 'invoice_code'], 'required'],
            [['email_status', 'flag'], 'string', 'max' => 4],
            [['invoice_code'], 'string', 'max' => 100],
            [['interest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interest::className(), 'targetAttribute' => ['interest_id' => 'interest_id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'order_id']],
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
            'tax_id' => 'GST Rate %',
            'order_id' => 'Unit Code',
            'interest_id' => 'Interest Rate %',
            'start_date' => 'Bill Date',
            'prev_lease_rent' => 'Previous Lease Rent (INR)',
            'prev_tax' => 'Previous Tax (SGST + CGST) (INR)',
            'prev_interest' => 'Previous Interest (INR)',
            'prev_dues_total' => 'Previous Dues Total (INR)',
            'current_lease_rent' => 'Current Lease Rent (INR)',
            'current_tax' => 'Current Tax (SGST + CGST) (INR)',
            'current_dues_total' => 'Current Dues Total (INR)',
            'due_date' => 'Due Date',
            'email_status' => 'Email Status',
            'lease_current_start' => 'Lease Current From Date',
            'lease_prev_start' => 'Lease Previous From Date',
            'total_amount' => 'Bill Amount',
            'flag' => 'Flag',
            'invoice_code' => 'Tax Invoice No',
        ];
    }

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

      public function getPenal(){
        $amount = Debit::find()->where(['invoice_id' => $this->invoice_id])
        ->sum('penal');
        return $amount;
      }

}
