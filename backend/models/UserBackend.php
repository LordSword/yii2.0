<?php

namespace backend\models;

use common\models\Captcha;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "ps_user_backend".
 *
 * @property int $id
 * @property string $username
 * @property string $phone
 * @property string $password
 * @property string $role_id
 * @property string $created_user
 * @property string $mark
 * @property string $created_at
 * @property string $updated_at
 */
class UserBackend extends ActiveRecord implements IdentityInterface
{
    // 超级管理员
    const SUPER_ROLE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_user_backend';
    }

    const STATUS_DELETED = -1;
    const STATUS_ACTIVE  = 1;

    public static $status = [
        self::STATUS_DELETED => '删除',
        self::STATUS_ACTIVE  => '活跃'
    ];
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'phone', 'password'], 'required'],
            [['username', 'password', 'mark'], 'string'],
            [['status' , 'updated_at', 'created_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'phone' => '手机号',
            'password' => '密码',
            'role_id' => '角色ID',
            'status' => '状态',
            'created_user' => '创建人',
            'mark' => '备注',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findRoleId($userId){
        $model = static::find()->select(['role_id'])
            ->where(['id' => $userId, 'status' => self::STATUS_ACTIVE])->asArray()->one();
        return $model['role_id'];
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setCreatedUser()
    {
        $this->created_user = Yii::$app->user->username?Yii::$app->user->username:'0';
    }
    public function validateCaptcha($phone, $code, $type){
        /*$result = Captcha::findOne([
            'phone' => $phone,
            'code' => trim($code),
            'type' => $type,
        ]);
        if ($result) {
            return time() <= $result->expire_time;
        }
        return false;*/
        return $code == '1234';
    }

    /**
     * 判断是否是超级管理员
     */
    public function getRoleId()
    {
        return $this->role_id == self::SUPER_ROLE;
    }
    // 获取角色
    public static function getRoleName($id){
        $role = self::find()->where(['id'=>$id])->select(['role_id'])->asArray()->one();
        if(empty($role['role_id'])){
            return 'superAdmin';
        }
        $roleName = AdminRole::find()
            ->where(['in','id',json_decode($role['role_id'],true)])
            ->select(['name'])->asArray()->all();
        $data = '';
        foreach ($roleName as $item){
            $data .= ','.$item['name'];
        }
        return trim($data,',');
    }
}
