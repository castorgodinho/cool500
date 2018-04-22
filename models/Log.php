<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $log_id
 * @property string $type
 * @property string $create_date
 * @property string $updated_date
 * @property string $old_value
 * @property string $new_value
 * @property int $user_id
 *
 * @property Users $user
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['create_date', 'updated_date'], 'safe'],
            [['old_value', 'new_value'], 'string'],
            [['user_id'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'type' => 'Type',
            'create_date' => 'Create Date',
            'updated_date' => 'Updated Date',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }
}
