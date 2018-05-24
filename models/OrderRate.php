<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_rate".
 *
 * @property int $order_rate_id
 * @property string $start_date
 * @property string $end_date
 * @property int $amount1
 * @property int $amount2
 * @property int $flag
 * @property int $order_id
 *
 * @property Orders $order
 */
class OrderRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'safe'],
            [['amount1', 'amount2', 'order_id'], 'integer'],
            [['flag'], 'string', 'max' => 4],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'order_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_rate_id' => 'Order Rate ID',
            'start_date' => 'From Date',
            'end_date' => 'To Date',
            'Lease rent' => 'Lease Rent',
            'Increment' => 'Increment',
            'flag' => 'Flag',
            'order_id' => 'Order ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['order_id' => 'order_id']);
    }
}
