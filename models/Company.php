<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $user_id
 * @property int $company_id
 * @property string $name
 * @property string $address
 * @property string $remark
 * @property string $constitution
 * @property string $products
 * @property string $gstin
 * @property string $owner_name
 * @property string $owner_phone
 * @property string $owner_mobile
 * @property string $competent_name
 * @property string $competent_email
 * @property string $competent_mobile
 * @property string $url
 * @property string $remark_url
 *
 * @property Users $user
 * @property Orders[] $orders
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            [['user_id', 'name', 'remark'], 'required'],
            [['user_id'], 'integer'],
            [['url', 'remark_url'], 'string'],
            [['name', 'owner_name', 'competent_name', 'competent_email'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 500],
            [['remark'], 'string', 'max' => 150],
            [['constitution', 'products'], 'string', 'max' => 60],
            [['gstin'], 'string', 'max' => 30],
            [['owner_phone', 'owner_mobile', 'competent_mobile'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'name' => 'Name',
            'address' => 'Address',
            'remark' => 'Remark',
            'constitution' => 'Constitution',
            'products' => 'Products',
            'gstin' => 'Gstin',
            'owner_name' => 'Owner Name',
            'owner_phone' => 'Owner Phone',
            'owner_mobile' => 'Owner Mobile',
            'competent_name' => 'Competent Name',
            'competent_email' => 'Competent Email',
            'competent_mobile' => 'Competent Mobile',
            'url' => 'Url',
            'remark_url' => 'Remark Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['company_id' => 'company_id']);
    }
}
