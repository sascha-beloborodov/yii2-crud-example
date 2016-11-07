<?php

namespace app\controllers\admin;

use app\common\controllers\auth\AdminAuth;
use app\models\Service;
use app\models\User;
use app\models\UserSiteForm;
use Yii;
use app\models\UsersSites;
use app\models\UsersSitesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UsersSitesController implements the CRUD actions for UsersSites model.
 */
class UsersSitesController extends AdminAuth
{

    /**
     * Lists all UsersSites models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSitesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersSites model.
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
     * Creates a new UsersSites model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserSiteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->saveNew()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UsersSites model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new UserSiteForm();
        $model->fillForm($id);

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UsersSites model.
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
     * get list of users by query
     * @return array|string|\yii\db\ActiveRecord[]
     */
    public function actionGetUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rq = Yii::$app->request;
        if (!$rq->isAjax) {
            return '';
        }
        $query = $rq->get('query');
        return User::find()
            ->where(['<>', 'role', User::ADMIN_ROLE])
            ->orWhere(['like', 'username', $query])
            ->orWhere(['like', 'first_name', $query])
            ->orWhere(['like', 'last_name', $query])
            ->orWhere(['like', 'email', $query])
            ->all();
    }

    public function actionGetServices()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rq = Yii::$app->request;
        if (!$rq->isAjax) {
            return '';
        }
        $query = $rq->get('query');
        return Service::find()
            ->orWhere(['like', 'type', $query])
            ->all();
    }

    /**
     * @return string|User
     */
    public function actionGetUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rq = Yii::$app->request;
        if (!$rq->isAjax) {
            return '';
        }
        $id = (int) $rq->get('id');
        return User::findOne(['id' => $id]);
    }

    /**
     * @return string|Service
     */
    public function actionGetService()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rq = Yii::$app->request;
        if (!$rq->isAjax) {
            return '';
        }
        $id = (int) $rq->get('id');
        return Service::findOne(['id' => $id]);
    }

    /**
     * Finds the UsersSites model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersSites the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersSites::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
