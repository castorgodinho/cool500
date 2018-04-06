<?php

namespace app\models;

use Yii;

class Users extends \yii\db\ActiveRecord
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
}
