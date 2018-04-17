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
            $previousLeaseRent = $model->prev_lease_rent;
            $previousCGST = 9;
            $previousSGST = 9;
            $previousCGSTAmount = $model->prev_tax/2;
            $previousSGSTAmount = $model->prev_tax/2;
            $previousTotalTax = $model->prev_tax;
            $previousDueTotal = $model->prev_dues_total;
            $penalInterest = $model->prev_interest;

            $currentLeaseRent = $model->current_lease_rent;
            $currentCGSTAmount = $model->current_tax/2;
            $currentSGSTAmount = $model->current_tax/2;
            $currentSGST = 9;
            $currentCGST = 9;
            $currentTotalTax = $model->current_tax;
            $currentDueTotal = $model->current_total_dues;

            $order =  Orders::findOne($model->order_id);

            $company = $order->company;
            $orderPlotArray = $order->plots;
            $totalArea = $order->total_area;
            $tax = Tax::find()->one(); #TODO
            $interest = Interest::find()->one(); #TODO
            $area = null;
            foreach ($orderPlotArray as $plot) {
              $area = $plot->area;
            }
            $rate = Rate::find()->where(['area_id' => $area->area_id])->one(); #TODO
            $currentLeaseRent   = $rate->rate * $totalArea;
            $taxAmout = $currentLeaseRent * ($tax->rate/100);



            date_default_timezone_set('Asia/Kolkata');
            $start_date = date('Y-m-d');

            return $this->render('view', [
                    'previousLeaseRent' => $previousLeaseRent,
                    'previousTotalTax' => $previousTotalTax,
                    'previousDueTotal' => $previousDueTotal,
                    'previousCGSTAmount' => $previousCGSTAmount,
                    'previousSGSTAmount' => $previousSGSTAmount,
                    'previousSGST' => $previousSGST,
                    'previousCGST' => $previousCGST,
                    'penalInterest' => $penalInterest,
                    'currentLeaseRent' => $currentLeaseRent,
                    'currentTotalTax' => $currentTotalTax,
                    'currentDueTotal' => $currentDueTotal,
                    'currentCGSTAmount' => $currentCGSTAmount,
                    'currentSGSTAmount' => $currentSGSTAmount,
                    'currentSGST' => $currentSGST,
                    'currentCGST' => $currentCGST,
                    'company' => $company,
                    'order' => $order,
                    'rate' => $rate,
                    'tax' => $tax,
                    'order_id' => $id,
                    'interest' => $interest,
                    'start_date' => $start_date,

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

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->invoice_id]);
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
