<?php

namespace app\controllers\admin;

use app\common\controllers\auth\AdminAuth;
use app\models\UserSiteForm;
use app\models\UsersSites;
use Yii;
use app\models\Service;
use app\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ServicesController implements the CRUD actions for Service model.
 */
class ServicesController extends AdminAuth
{

    const LIMIT = 20;
    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Service model.
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
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Service model.
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
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionGetUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rq = Yii::$app->request;
        $page = (int) $rq->get('page');
        $query = $rq->get('query');

        if (1 >= $page) {
            $page = 0;
        } else {
            --$page;
        }

        $totalRecords = UsersSites::getCount($query);
        if ($totalRecords % self::LIMIT != 0) {
            $totalPages = round($totalRecords/self::LIMIT) + 1;
        } else {
            $totalPages = round($totalRecords/self::LIMIT);
        }

        return [
            'data' => UsersSites::getList(self::LIMIT, $page * self::LIMIT, $query),
            'pagination' => [
                'total' => $totalRecords,
                'per_page' => self::LIMIT,
                'from' => $page * self::LIMIT + 1,
                'to' => $page * self::LIMIT + self::LIMIT,
                'last_page' => $totalPages,
                'current_page' => !$page ? 1 : $page + 1
            ]
        ];
    }

    public function actionEditData()
    {
        $rq = Yii::$app->request;
        $id = $rq->get('id');
        if (!$rq->isAjax || !(int) $id) {
            return '';
        }
        $model = new UserSiteForm();
        $model->is_active = 1;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load($rq->post()) && $model->validate()) {
            if ($model->update($id)) {
                return '1';
            }
        }
        Yii::$app->response->statusCode = 403;
        return $model->errors;
    }

    public function actionRemoveData()
    {

    }


    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
