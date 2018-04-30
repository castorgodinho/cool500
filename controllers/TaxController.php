<?php

namespace app\controllers;

use Yii;
use app\models\Tax;
use app\models\SearchTax;
use app\models\Log;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaxController implements the CRUD actions for Tax model.
 */
class TaxController extends Controller
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
     * Lists all Tax models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexTax')){
            $searchModel = new SearchTax();
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
     * Displays a single Tax model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewTax')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Tax model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createTax')){
            $model = new Tax();

            if ($model->load(Yii::$app->request->post())) {
                date_default_timezone_set('Asia/Kolkata');
                $model->date = date('Y-m-d');
                $model->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Tax model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateTax')){
            $model = $this->findModel($id);
            $model->flag = 0;
            
            $tax = new Tax();
            if ($tax->load(Yii::$app->request->post())) {
                date_default_timezone_set('Asia/Kolkata');
                $tax->date = date('Y-m-d');
                $log = new Log();
                $log->old_value = Json::encode(Tax::find()->where(['tax_id' => $model->tax_id])->all(), $asArray = true) ;
                $tax->save();
                $model->save();
                $log->new_value = Json::encode(Tax::find()->where(['tax_id' => $tax->tax_id])->all(), $asArray = true) ;
                $log->user_id = Yii::$app->user->identity->user_id;
                $log->type = 'Edited Tax';
                $log->save();
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Tax model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteTax')){
            $model = Tax::findOne($id);
            $model->flag = 0;
            $model->save();
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Tax model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tax the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tax::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
