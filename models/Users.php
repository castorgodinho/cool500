<?php

namespace app\models;

use Yii;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['password'], 'string'],
            [['email'], 'string', 'max' => 100],
        ];
    }


    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function create($email,$password){
      $user = new Users();
      $user->email = $email;
      $user->password = $password;
      $user->save();
      return $user;
    }


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
        return static::find()->where(['email' => $username])->one();
    }

}
