<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plot".
 *
 * @property integer $plot_id
 * @property integer $area_id
 * @property string $name
 * @property integer $area_of_plot
 *
 * @property CompanyPlot[] $companyPlots
 * @property Invoice[] $invoices
 * @property Area $area
 */
class Plot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'area_of_plot'], 'integer'],
            [['name', 'area_of_plot'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'area_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plot_id' => 'Plot ID',
            'area_id' => 'Area ID',
            'name' => 'Name',
            'area_of_plot' => 'Area Of Plot',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyPlots()
    {
        return $this->hasMany(CompanyPlot::className(), ['plot_id' => 'plot_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['plot_id' => 'plot_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['area_id' => 'area_id']);
    }
}
