<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tax".
 *
 * @property integer $tax_id
 * @property string $name
 * @property integer $rate
 * @property string $date
 *
 * @property Invoice[] $invoices
 */
class Tax extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tax';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate'], 'required'],
            [['rate'], 'integer'],
            [['date','flag'], 'safe'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tax_id' => 'Tax ID',
            'name' => 'Name',
            'rate' => 'TAX (GST) Rate',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['tax_id' => 'tax_id']);
    }
}
