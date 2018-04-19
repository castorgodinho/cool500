<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rate".
 *
 * @property integer $rate_id
 * @property integer $area_id
 * @property integer $from_area
 * @property integer $to_area
 * @property integer $rate
 * @property string $date
 *
 * @property AreaRate[] $areaRates
 * @property Area[] $areas
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
            [['area_id', 'from_area', 'to_area', 'rate', 'date'], 'required'],
            [['area_id', 'from_area', 'to_area', 'rate'], 'integer'],
            [['date','flag'], 'safe'],
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
            'to_area' => 'To Area',
            'rate' => 'Lease Rate',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaRates()
    {
        return $this->hasMany(AreaRate::className(), ['rate_id' => 'rate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['area_id' => 'area_id'])->viaTable('area_rate', ['rate_id' => 'rate_id']);
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
