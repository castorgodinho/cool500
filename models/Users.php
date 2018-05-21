<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $email
 * @property string $password
 * @property string $type
 *
 * @property Company[] $companies
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $password_repeat;
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'mobile'], 'required', 'on' => 'create'],
            [['password', 'password_repeat'], 'string'],
            [['password_repeat'], 'compare', 'compareAttribute'=>'password', 'on' => 'update-password', 'message'=>"Passwords don't match"],
            [['email'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 50],
            [['email', 'mobile'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'password' => 'Password',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['user_id' => 'user_id']);
    }

    public static function findIdentity($id)
    {
        return static::find()->where(['user_id' => $id])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findByUsername($username)
    {
        if($user = static::find()->where(['email' => $username])->one()){
            return $user;
        }else{
            return static::find()->where(['mobile' => $username])->one();
        }
    }

}
