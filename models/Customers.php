<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property integer $id
 * @property string $identity
 * @property string $password
 * @property string $ip_address
 * @property integer $active
 * @property string $full_name
 * @property string $phone
 * @property string $bdate
 * @property integer $sex
 * @property string $photo
 * @property string $email
 * @property string $city_b
 * @property string $country_b
 * @property integer $quick_order
 * @property integer $get_information
 * @property integer $authorization_quantity
 * @property string $confirm_pass
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customers';
    }

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'sex', 'quick_order', 'get_information', 'authorization_quantity'], 'integer'],
            [['phone'], 'required'],
            [['identity', 'password', 'ip_address', 'full_name', 'phone', 'photo', 'email', 'city_b', 'country_b', 'confirm_pass'], 'string', 'max' => 255],
            [['bdate'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identity' => 'Identity',
            'password' => 'Password',
            'ip_address' => 'Ip Address',
            'active' => 'Active',
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'bdate' => 'Bdate',
            'sex' => 'Sex',
            'photo' => 'Photo',
            'email' => 'Email',
            'city_b' => 'City B',
            'country_b' => 'Country B',
            'quick_order' => 'Quick Order',
            'get_information' => 'Get Information',
            'authorization_quantity' => 'Authorization Quantity',
            'confirm_pass' => 'Confirm Pass',
        ];
    }

    public static function getNames(){
        return self::find()->select('id,full_name')->groupBy('full_name')->indexBy('id')->asArray()->all();
    }

    public static function getUserName(){
        return self::find()->select('full_name,id')->where('full_name IS NOT NULL')->asArray()->all();
    }
}
