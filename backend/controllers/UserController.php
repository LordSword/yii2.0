<?php

namespace backend\controllers;

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
     * Lists all UserBackend models.
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
     * Displays a single UserBackend model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserBackend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminRole();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('role-create', [
                'model' => $model,
            ]);
        }
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
