<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_rate".
 *
 * @property int $area_rate_id
 * @property int $rate
 * @property string $start_date
 *
 * @property Area[] $areas
 */
class AreaRate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area_rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate'], 'required'],
            [['rate'], 'integer'],
            [['start_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_rate_id' => 'Area Rate ID',
            'rate' => 'Rate',
            'start_date' => 'Start Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['area_rate_id' => 'area_rate_id']);
    }
}
