<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rate".
 *
 * @property int $rate_id
 * @property int $area_id
 * @property int $rate
 * @property string $date
 * @property int $flag
 * @property int $extra
 *
 * @property Invoice[] $invoices
 * @property Area $area
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'rate', 'date', 'extra'], 'required'],
            [['area_id', 'rate', 'extra'], 'integer'],
            [['date'], 'safe'],
            [['flag'], 'string', 'max' => 2],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'area_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rate_id' => 'Rate ID',
            'area_id' => 'Area ID',
            'rate' => 'Rate',
            'date' => 'Date',
            'flag' => 'Flag',
            'extra' => 'Extra',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['rate_id' => 'rate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['area_id' => 'area_id']);
    }
}
