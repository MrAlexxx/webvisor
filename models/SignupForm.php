<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;
use yii\db\Query;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $name;
    public $password;
    public $confirm;
    public $rememberMe;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'match', 'pattern' => '/^[a-zA-Z-0-9]+$/', 'message' => "Логін повинно містити лише буквені символи, без пробілів"],

            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'password', 'email', 'confirm'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такий логін вже зареєстровано'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такий email вже зареєстровано'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['confirm', 'compare', 'compareAttribute'=>'password', 'message'=>'Паролі не співпали' ],
//            ['verifyCode', 'captcha', 'Не введен код']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логін',
            'password' => 'Пароль',
            'email' => 'Email',
            'confirm' =>  'Подтверждение пароля',
            'rememberMe' => "Запам'ятати меня"
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
