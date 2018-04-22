<?php
namespace app\models;

use yii\web\UploadedFile;
use Yii;

class RemarkImage extends \yii\base\Model
{

    /**
     *
     * @inheritdoc
     */
    public $file;
    public $url;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file'], 
            [['url'], 'string']           
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'File'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->url = 'remarkfiles/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs('remarkfiles/' . $this->file->baseName . '.' . $this->file->extension);
            echo $this->url;
            return true;
        } else {
            return false;
        }
    }

}
