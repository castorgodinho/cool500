<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "debit".
 *
 * @property int $debit_id
 * @property int $penal
 * @property int $invoice_id
 *
 * @property Invoice $invoice
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
            [['penal', 'invoice_id'], 'integer'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'invoice_id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['invoice_id' => 'invoice_id']);
    }
}
