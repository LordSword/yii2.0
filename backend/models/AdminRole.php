<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ps_admin_role".
 *
 * @property int $id ID
 * @property string $name 角色名称
 * @property string $desc 描述
 * @property string $permissions 权限集合
 * @property string $created_user 创建人
 * @property int $updated_at 更新时间
 * @property int $created_at 创建时间
 */
class AdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'desc', 'permissions'], 'required'],
            [['permissions'], 'string'],
            [['updated_at', 'created_at'], 'integer'],
            [['name', 'desc', 'created_user'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '角色名称',
            'desc' => '描述',
            'permissions' => '权限集合',
            'created_user' => '创建人',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }
    // 获取所有角色
    public static function getAllRole(){
        return self::find()->select(['id','name'])->where('id!=1')->asArray()->all();
    }

    /**
     * @name 获取用户的权限
     * @param $roleId string 角色ID
     * @inheritdoc
     */
    public static function getActionId($roleId)
    {
        $roleIds = array_filter(explode(',', $roleId));
        $permissions = static::find()->select(['permissions'])
            ->where(['in', 'id', $roleIds])->asArray()->all();
        $permissions = array_column($permissions, 'permissions');
        $array = [];
        foreach ($permissions as $item) {
            $tempArray = array_filter(explode(',', $item));
            foreach ($tempArray as $value) {
                $array[] = $value;
            }
        }
        return $array;
    }
}
