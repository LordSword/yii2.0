<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ps_admin_role".
 *
 * @property int $id ID
 * @property string $name 标识
 * @property string $title 角色名称
 * @property string $desc 描述
 * @property string $top_menu 一级菜单
 * @property string $menu 二级菜单
 * @property string $permissions 权限集合
 * @property string $created_user 创建人
 * @property int $updated_at 更新时间
 * @property int $created_at 创建时间
 * @property int $groups 分组id
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
            [['name', 'title', 'desc', 'created_user'], 'required'],
            [['menu', 'permissions'], 'string'],
            [['updated_at', 'created_at'], 'integer'],
            [['name', 'title', 'desc', 'created_user'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标识',
            'title' => '角色名称',
            'desc' => '描述',
            'top_menu' => 'Top Menu',
            'menu' => 'Menu',
            'permissions' => 'Permissions',
            'created_user' => '创建人',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
            'groups' => 'Groups',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
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
