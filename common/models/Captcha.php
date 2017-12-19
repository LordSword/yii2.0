<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ps_captcha".
 *
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string $phone
 * @property int $type
 * @property string $code
 * @property int $generate_time
 * @property int $expire_time
 */
class Captcha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_captcha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'phone', 'type'], 'required'],
            [['user_id', 'phone', 'type'], 'integer'],
            [['username'], 'string', 'max' => 32],
            ['code', 'default', 'value'=>rand(100000,999999)],
            ['generate_time', 'default', 'value'=>time()],
            ['expire_time', 'default', 'value'=>time()+30*60],
        ];
    }
    const TYPE_ADMIN_LOGIN = 1;

    public static function addLog($phone, $user_id, $username, $type){
        $result = self::getLastRecord($phone, $type);
        if($result && $result->expire_time > time()){
            return $result->code;
        }
        $model = new self();
        $model->user_id = $user_id;
        $model->username = $username;
        $model->type = $type;
        $model->phone = $phone;
        if($model->save()){
            return $model->code;
        }
        return false;
    }
    public static function getLastRecord($phone, $type){
        return self::find()
            ->where(['phone'=>$phone,'type'=>$type])
            ->orderBy(['id'=>SORT_DESC])
            ->one();
    }
}
