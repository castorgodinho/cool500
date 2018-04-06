<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rate".
 *
 * @property integer $rate_id
 * @property integer $area_id
 * @property integer $from_area
 * @property integer $to_are
 * @property integer $rate
 * @property string $date
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
            [['area_id', 'from_area', 'to_are', 'rate', 'date'], 'required'],
            [['area_id', 'from_area', 'to_are', 'rate'], 'integer'],
            [['date'], 'safe'],
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
            'from_area' => 'From Area',
            'to_are' => 'To Are',
            'rate' => 'Rate',
            'date' => 'Date',
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
