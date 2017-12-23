<?php

namespace backend\controllers;

use backend\models\ActionModel;
use backend\models\AdminRole;
use Yii;
use backend\models\UserBackend;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for UserBackend model.
 */
class UserController extends BaseController
{
    /**
     * @name 角色列表
     * @return mixed
     */
    public function actionRoleList()
    {
        $query = AdminRole::find();
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->pageSize = 15;
        $roleList = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('role-list', [
            'roleList' => $roleList,
            'pages' => $pages
        ]);
    }
    /**
     * @name 管理员列表
     */
    public function actionList(){
        $query = UserBackend::find();
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages->pageSize = 15;
        $roleList = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list', [
            'list' => $roleList,
            'pages' => $pages
        ]);
    }

    /**
     * @name 添加管理员
     */
    public function actionAddAdmin(){
        $model = new UserBackend();
        if($model->load($this->request->post())){
            $model->role_id = json_encode($this->request->post('roleId'));
            $model->created_user = Yii::$app->user->identity->username;
            if($model->save()){
                return $this->redirect(['list']);
            }
        }

        return $this->render('add-admin', [
            'model' => $model,
        ]);
    }

    /**
     * @name 添加角色
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminRole();

        if ($model->load($this->request->post())) {
            $model->permissions = json_encode($this->request->post('permissions'));
            $model->created_user = Yii::$app->user->identity->username;
            if($model->save()){
                return $this->redirect(['role-list']);
            }
        }

        return $this->render('role-create', [
            'model' => $model,
            'permissions' => $this->getPermission(),
        ]);
    }

    /**
     * @name 编辑角色权限
     */
    public function actionAuthEdit($role_id){
        $model = AdminRole::findOne($role_id);
        $permissionChecks = $model->permissions ? json_decode($model->permissions, true) : [];

        if ($model->load($this->request->post())) {
            $model->permissions = json_encode($this->request->post('permissions'));
            $model->created_user = Yii::$app->user->identity->username;
            if($model->save()){
                return $this->redirect(['role-list']);
            }
        }

        return $this->render('role-edit', [
            'model' => $model,
            'permissions' => $this->getPermission(),
            'permissionChecks' => $permissionChecks,
        ]);
    }

    private function getPermission(){
        $controllers = Yii::$app->params['permissionControllers'];
        $permissions = [];
        foreach ($controllers as $controller => $label) {
            $actions = [];
            $rf = new \ReflectionClass("backend\\controllers\\{$controller}");
            $methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                if (strpos($method->name, 'action') === false || $method->name == 'actions') {
                    continue;
                }
                $actions[] = new ActionModel($method);
            }
            $permissions[$controller] = [
                'label' => $label,
                'actions' =>$actions,
            ];
        }
        return $permissions;
    }


    /**
     * @name 删除角色
     */
    public function actionDeleteRole($role_id){
        $model = AdminRole::findOne($role_id);
        $model->delete();
        return $this->redirect(['role-list']);
    }

    /**
     * @name 删除后台管理员
     */
    public function actionDeleteUser($id){

    }

    public function actionAaa(){
        $a = Yii::$app->redis->executeCommand('SET',['aa',11,'EX',600]);
        echo $a."<br>";
        echo Yii::$app->redis->executeCommand('GET',['aa']);
    }

    /**
     * Updates an existing UserBackend model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserBackend model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserBackend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserBackend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBackend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *  create new user
     */
    public function actionSignup ()
    {
        $model = new \backend\models\SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {

            return $this->redirect(['index']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
