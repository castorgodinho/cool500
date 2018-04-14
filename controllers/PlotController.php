<?php

namespace app\controllers;

use Yii;
use app\models\Plot;
use app\models\Area;
use app\models\SearchPlot;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlotController implements the CRUD actions for Plot model.
 */
class PlotController extends Controller
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
     * Lists all Plot models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexPlot')){
            $searchModel = new SearchPlot();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Displays a single Plot model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewPlot')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Plot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createPlot')){
            $model = new Plot();
            $area = Area::find()->all();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->plot_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'area' => $area,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Plot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->plot_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Plot model.
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
     * Finds the Plot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plot::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
