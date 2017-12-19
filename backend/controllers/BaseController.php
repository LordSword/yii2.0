<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2017/8/15
 * Time: 22:31
 */
namespace backend\controllers;

use backend\models\AdminRole;
use Yii;
use yii\web\ForbiddenHttpException;

abstract class BaseController extends \common\components\BaseController
{
    // 是否验证本系统的权限逻辑
    public $verifyPermission = true;

    public function beforeAction ($action)
    {
        parent::beforeAction($action);
        if($this->verifyPermission){
            // 验证登录
            if (Yii::$app->user->getIsGuest()) {
                return $this->redirect(['site/login']);
            }
            if(!Yii::$app->user->identity->roleId){
                $permissions = Yii::$app->getSession()->get('admin_permissions');
                if ($permissions) {
                    $permissions = json_decode($permissions, true);
                    if (!in_array($this->getRoute(), $permissions)) {
                        throw new ForbiddenHttpException('您所属的管理员角色无此权限');
                    }
                } else {
                    $roleId = Yii::$app->user->identity->role_id;
                    if ($roleId) {
                        $array = AdminRole::getActionId($roleId);
                        Yii::$app->getSession()->set('admin_permissions', json_encode($array));
                        if (!in_array($this->getRoute(), $array)) {
                            throw new ForbiddenHttpException('您所属的管理员角色无此权限');
                        }
                    }else{
                        throw new ForbiddenHttpException('您所属的管理员角色尚未分配权限');
                    }
                }
            }
        }
        return true;
    }
    // 获得请求对象
    public function getRequest()
    {
        return \Yii::$app->getRequest();
    }

    // 获得返回对象
    public function getResponse()
    {
        return \Yii::$app->getResponse();
    }
}