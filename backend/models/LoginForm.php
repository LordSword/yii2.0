<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\UserBackend;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $phoneCaptcha;
    public $verifyCode;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        if(YII_ENV_PROD){
            return [
                [['username', 'password' , 'phoneCaptcha'], 'required'],
                ['password', 'validatePassword'],
                ['phoneCaptcha', 'validateCaptcha'],
            ];
        }else{
            return [
                [['username', 'password'], 'required'],
                ['password', 'validatePassword'],
            ];
        }

    }
    public function attributeLabels()
    {
        return [
            'username'     => '用户名',
            'password'     => '密码',
            'phoneCaptcha' => '验证码',
            'verifyCode'   => '验证码',
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }

    public function validateCaptcha($attribute){
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validateCaptcha($user->phone, $this->phoneCaptcha, Captcha::TYPE_ADMIN_LOGIN)) {
                $this->addError($attribute, '验证码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            if(is_numeric($this->username)){
                $this->_user = UserBackend::findByPhone($this->username);

            }else{
                $this->_user = UserBackend::findByUsername($this->username);
            }
        }

        return $this->_user;
    }
}
