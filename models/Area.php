<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property int $area_id
 * @property string $name
 * @property int $total_area
 *
 * @property AreaRate[] $areaRates
 * @property Plot[] $plots
 * @property Rate[] $rates
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $area_rate;

    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_area', 'area_rate'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Industrial Estate',
            'name' => 'Name',
            'total_area' => 'Total Area',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaRates()
    {
        return $this->hasMany(AreaRate::className(), ['area_id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlots()
    {
        return $this->hasMany(Plot::className(), ['area_id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRates()
    {
        return $this->hasMany(Rate::className(), ['area_id' => 'area_id']);
    }
}
