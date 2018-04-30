<?php

namespace app\controllers;

use Yii;
use app\models\Area;
use app\models\AreaRate;
use app\models\Log;
use yii\helpers\Json;
use app\models\SearchArea;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
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
     * Lists all Area models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexArea')){
            $searchModel = new SearchArea();
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
     * Displays a single Area model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewArea')){
            return $this->render('view', [
                'model' => $this->findModel($id),
                'id' => $id,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createArea')){
            $model = new Area();
            if ($model->load(Yii::$app->request->post())) {
                $rate = new AreaRate();
                $rate->area_rate = $model->area_rate;
                $model->total_area = 0;
                $model->save();
                $rate->area_id = $model->area_id;
                $rate->start_date = date('Y-m-d');
                $rate->save(false);
                return $this->redirect(['view', 'id' => $model->area_id]);
            }
            else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateArea')){
            $model = $this->findModel($id);
            $model->area_rate = AreaRate::find()->orderBy('start_date DESC')->one()->area_rate;
            if ($model->load(Yii::$app->request->post())) {
                $rate = new AreaRate();
                $rate->area_rate = $model->area_rate;
                $rate->area_id = $model->area_id;
                $rate->start_date = date('Y-m-d');
                $log = new Log();
                $log->old_value = Json::encode(Area::find()->where(['area_id' => $model->area_id])->one(), $asArray = true) ;
                $rate->save(false);
                $model->save();
                $log->new_value = Json::encode(Area::find()->where(['area_id' => $model->area_id])->one(), $asArray = true) ;
                $log->user_id = Yii::$app->user->identity->user_id;
                $log->type = 'Edited Industrial Area';
                $log->save();
                return $this->redirect(['view', 'id' => $model->area_id]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Area model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteArea')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
