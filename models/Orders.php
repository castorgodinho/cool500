<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property string $order_number
 * @property int $company_id
 * @property int $built_area
 * @property int $shed_area
 * @property int $godown_area
 * @property string $start_date
 * @property string $end_date
 * @property string $shed_no
 * @property string $godown_no
 * @property int $area_id
 * @property int $total_area
 * @property string $plots
 *
 * @property Invoice[] $invoices
 * @property Plot[] $plots0
 * @property Area $area
 * @property Company $company
 * @property Payment[] $payments
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public $file;
    public $transfer_file;
    public function rules()
    {
        return [
            [['order_number', 'company_id', 'total_area', 'plots'], 'required'],
            [['company_id', 'built_area', 'shed_area', 'godown_area', 'area_id', 'total_area'], 'integer'],
            [['start_date', 'end_date', 'document','remark'], 'safe'],
            [['file', 'transfer_file'], 'file'],
            [['order_number'], 'string', 'max' => 20],
            [['shed_no', 'godown_no'], 'string', 'max' => 50],
            [['plots'], 'string', 'max' => 100],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'area_id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'company_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Unit ID',
            'order_number' => 'Unit Number',
            'company_id' => 'Company Name',
            'built_area' => 'Built Area',
            'shed_area' => 'Shed Area',
            'godown_area' => 'Godown Area',
            'start_date' => 'Allotted Date',
            'end_date' => 'Renewal Date',
            'shed_no' => 'Shed No',
            'godown_no' => 'Godown No',
            'area_id' => 'Industrial Estate',
            'total_area' => 'Plot Area',
            'plots' => 'Plots',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['order_id' => 'order_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlots0()
    {
        return $this->hasMany(Plot::className(), ['plot_id' => 'plot_id'])->viaTable('order_details', ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['area_id' => 'area_id']);
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
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['order_id' => 'order_id']);
    }

    public function upload()
    {
            $this->document = 'unit_documents/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs('unit_documents/' . $this->file->baseName . '.' . $this->file->extension);
            echo $this->document;

            
    }

    public function uploadTranfer(){
        $this->transfer_url = 'unit_documents/' . $this->transfer_file->baseName . '.' . $this->transfer_file->extension;
        $this->transfer_file->saveAs('unit_documents/' . $this->transfer_file->baseName . '.' . $this->transfer_file->extension);
        return true;
    }
}
