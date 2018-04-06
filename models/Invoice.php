<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $invoice_id
 * @property integer $company_id
 * @property integer $plot_id
 * @property integer $rate_id
 * @property integer $tax_id
 * @property string $date
 *
 * @property Company $company
 * @property Plot $plot
 * @property Rate $rate
 * @property Tax $tax
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'plot_id', 'rate_id', 'tax_id', 'date'], 'required'],
            [['company_id', 'plot_id', 'rate_id', 'tax_id'], 'integer'],
            [['date'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'company_id']],
            [['plot_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plot::className(), 'targetAttribute' => ['plot_id' => 'plot_id']],
            [['rate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rate::className(), 'targetAttribute' => ['rate_id' => 'rate_id']],
            [['tax_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tax::className(), 'targetAttribute' => ['tax_id' => 'tax_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'company_id' => 'Company ID',
            'plot_id' => 'Plot ID',
            'rate_id' => 'Rate ID',
            'tax_id' => 'Tax ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlot()
    {
        return $this->hasOne(Plot::className(), ['plot_id' => 'plot_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['rate_id' => 'rate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['tax_id' => 'tax_id']);
    }
}
