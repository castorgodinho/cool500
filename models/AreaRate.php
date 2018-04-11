<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "area_rate".
 *
 * @property int $area_rate_id
 * @property int $area_id
 * @property int $area_rate
 * @property string $start_date
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
            [['area_id', 'area_rate'], 'integer'],
            [['area_rate', 'start_date'], 'required'],
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
            'area_id' => 'Area ID',
            'area_rate' => 'Area Rate',
            'start_date' => 'Start Date',
        ];
    }
}
