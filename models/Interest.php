<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interest".
 *
 * @property int $interest_id
 * @property string $name
 * @property string $type
 * @property int $rate
 * @property string $start_date
 *
 * @property Invoice[] $invoices
 */
class Interest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate'], 'integer'],
            [['start_date' , 'flag'], 'safe'],
            [['name', 'type'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'interest_id' => 'Interest ID',
            'name' => 'Name',
            'type' => 'Type',
            'rate' => 'Interest Rate',
            'start_date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['interest_id' => 'interest_id']);
    }
}
