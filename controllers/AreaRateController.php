<?php

namespace app\controllers;

use Yii;
use app\models\AreaRate;
use app\models\SearchAreaRate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AreaRateController implements the CRUD actions for AreaRate model.
 */
class AreaRateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AreaRate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAreaRate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AreaRate model.
     * @param integer $area_id
     * @param integer $rate_id
     * @return mixed
     */
    public function actionView($area_id, $rate_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($area_id, $rate_id),
        ]);
    }

    /**
     * Creates a new AreaRate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AreaRate();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'area_id' => $model->area_id, 'rate_id' => $model->rate_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AreaRate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $area_id
     * @param integer $rate_id
     * @return mixed
     */
    public function actionUpdate($area_id, $rate_id)
    {
        $model = $this->findModel($area_id, $rate_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'area_id' => $model->area_id, 'rate_id' => $model->rate_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AreaRate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $area_id
     * @param integer $rate_id
     * @return mixed
     */
    public function actionDelete($area_id, $rate_id)
    {
        $this->findModel($area_id, $rate_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AreaRate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $area_id
     * @param integer $rate_id
     * @return AreaRate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($area_id, $rate_id)
    {
        if (($model = AreaRate::findOne(['area_id' => $area_id, 'rate_id' => $rate_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}