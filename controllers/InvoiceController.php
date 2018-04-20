<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\OrderDetails;
use app\models\Area;
use app\models\Plot;
use app\models\Tax;
use app\models\Interest;
use app\models\Payment;
use app\models\Rate;
use app\models\Invoice;
use app\models\SearchInvoice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexInvoice')){
            $searchModel = new SearchInvoice();
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
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Invoice::findOne($id);
        if (\Yii::$app->user->can('viewInvoice', ['invoice' => $model])){

            $time = strtotime($model->start_date);
            $start_date = date('d-m-Y',$time);
            $invoiceDueDate = date('d-m-Y', strtotime($start_date. ' + 1 month'));

            $leasePeriodFrom = $invoiceDueDate;
            $leasePeriodTo = date('d-m-Y', strtotime($invoiceDueDate. ' + 1 year - 1 day'));

            $prevPeriodFrom = date('d-m-Y', strtotime($invoiceDueDate. ' - 1 year'));
            $prevPeriodTo = date('d-m-Y', strtotime($invoiceDueDate. ' - 1 day'));

            return $this->render('view', [
                    'start_date' => $start_date,
                    'invoiceDueDate' => $invoiceDueDate,
                    'leasePeriodFrom' => $leasePeriodFrom,
                    'leasePeriodTo' => $leasePeriodTo,
                    'prevPeriodFrom' => $prevPeriodFrom,
                    'prevPeriodTo' => $prevPeriodTo,
                    'model' => $model,
                ]);
        }else{
                throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createInvoice')){
            $model = new Invoice();

            if ($model->load(Yii::$app->request->post())) {
                  $model->save();
                return $this->redirect(['index']);
            }

             return $this->render('create', [
                 'model' => $model,
             ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateInvoice')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->invoice_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteInvoice')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
