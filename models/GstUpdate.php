<?php
namespace app\models;

use yii\web\UploadedFile;
use Yii;

class GstUpdate extends \yii\base\Model
{

    /**
     *
     * @inheritdoc
     */
    public $gstin;
    public $file;
    public $url;

    public function rules()
    {
        return [
            [['gstin', 'file'], 'required'],
            [['file'], 'file'],
            [
                [
                    'gstin',
                    'url',
                ],
                'string'
            ],


        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gstin' => Yii::t('app', 'GSTIN'),
            'file' => Yii::t('app', 'File'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->url = 'gstfiles/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs('gstfiles/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }

}
