<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property integer $area_id
 * @property string $name
 *
 * @property Plot[] $plots
 * @property Rate[] $rates
 */
class Area extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'area';
    }


    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
        ];
    }


    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'name' => 'Area Name',
        ];
    }

    public function create($name){
      $area = new Area();
      $area->name = $name;
      $area->save();
      return $area;
    }


    public function getPlots()
    {
        return $this->hasMany(Plot::className(), ['area_id' => 'area_id']);
    }


    public function getRates()
    {
        return $this->hasMany(Rate::className(), ['area_id' => 'area_id']);
    }
}
