<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\Area;
use app\models\Plot;
use app\models\Tax;
use app\models\Interest;
use app\models\OrderRate;
use app\models\Payment;
use app\models\Rate;
use app\models\Invoice;
use app\models\MyInvoice;
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

    public function actionGenerate($order_id){
              date_default_timezone_set('Asia/Kolkata');
              $model = new Invoice();
              if ($model->load(Yii::$app->request->post())) {
                $invoiceCode = '';
                $model->total_amount = round($model->total_amount);
                $order =  Orders::findOne($order_id);
                $time = strtotime($order->start_date);
                $area = $model->order->area;
                $areaCode = strtoupper(substr($area->name,0,3));
                $invoiceCode = $areaCode .'/';

                $due_date =  $model->due_date;

                $year = date('Y');
                $year = substr($year,2,3);
                $invoiceCode = $areaCode . '/' . $year;
                $year = intval($year) + 1;
                $invoiceCode = $invoiceCode . '-' . $year;
                $model->invoice_code = 'hello';
                $model->save(False);
                $invoiceID = strval($model->invoice_id);
                $len = strlen($invoiceID);
                for ($i=0; $i < (4 - $len); $i++) {
                  $invoiceID = '0'. $invoiceID;
                }
                $invoiceCode = $invoiceCode . '/' . $invoiceID;
                $model->invoice_code = $invoiceCode;
                $model->due_date = date('Y-m-d', strtotime($due_date. ''));
                $model->save(False);
                return $this->redirect(['invoice/index']);
              } else{

                $order =  Orders::findOne($order_id);
                $order_rate = OrderRate::find()
                ->where(['order_id' => $order->order_id ])
                ->andWhere(['flag' => 1])
                ->one();

                $tax = Tax::find()
                ->where(['name' => 'GST'])
                ->where(['flag' => 1])
                ->one();

                $interest = Interest::find()
                ->where(['name' => 'Penal Interest'])
                ->andWhere(['flag' => 1])
                ->one();

                $area = $order->area;
                $company = $order->company;

                $rate = Rate::find()->where(['area_id' => $area->area_id])
                ->andWhere(['flag' => 1])
                ->one();

                $start_date = date('d-m-Y');
                $diffDate = 0;

                $previousCGSTAmount = 0;
                $previousSGSTAmount = 0;

                $model->prev_lease_rent=0;
                $model->prev_tax = 0;
                $model->prev_interest = 0;
                $model->prev_dues_total=0;
                $model->prev_tax=0;

               $model->current_lease_rent = $order_rate->amount1;
               $model->current_tax = $model->current_lease_rent * ($tax->rate/100);
               $currentCGSTAmount = (($tax->rate/2)/100) * $model->current_lease_rent;
               $currentSGSTAmount = $currentCGSTAmount;
               $model->current_total_dues = $model->current_lease_rent + $model->current_tax;


               $invoice = Invoice::find()
               ->where(['order_id' => $order_id])
               ->orderBy(['invoice_id' => SORT_DESC])
               ->one();

               $time = strtotime($start_date);
               $newformat = date('d-m-Y',$time);
               $invoiceDueDate = date('d-m-Y', strtotime($newformat. ' + 1 year 15 days'));
               $model->due_date = $invoiceDueDate;

               $billDate = $start_date;

               if($start_date > $order_rate->end_date ){
                $model->current_lease_rent = $model->current_lease_rent + $order_rate->amount1;
               }

               if($invoice){

                 $totalPaid = Payment::find()
                 ->where(['invoice_id' => $invoice->invoice_id])
                 ->andWhere(['status' => 1])
                 ->sum('amount');

                 $pi = Payment::find()
                 ->where(['invoice_id' => $invoice->invoice_id])
                 ->andWhere(['status' => 1])
                 ->sum('penal');

                 $model->prev_dues_total = $invoice->grand_total - $totalPaid + $pi;

                 $model->prev_lease_rent = $invoice->current_lease_rent;
                 $model->prev_tax = $invoice->current_tax;
                 $previousCGSTAmount =  (($invoice->tax->rate/2)/100) * $invoice->current_lease_rent;
                 $previousSGSTAmount = $previousCGSTAmount;

                 $invoiceDueDate = date('d-m-Y', strtotime($invoice->due_date. ' + 1 year '));
                 $model->due_date = $invoiceDueDate;

                 $date1 = $invoiceDueDate;
                 $date2 = $start_date;
                 $diff = strtotime($date2) - strtotime($date1);
                 $diffDate  = $diff / (60*60*24);

                 $leasePeriodFrom = date('d-m-Y', strtotime($invoiceDueDate. ''));
                 $leasePeriodTo = date('d-m-Y', strtotime($invoiceDueDate. ' + 1 year - 1 day'));

                 $prevPeriodFrom = date('d-m-Y', strtotime($leasePeriodFrom. ' - 1 year '));
                 $prevPeriodTo   = date('d-m-Y', strtotime($leasePeriodFrom. ' - 1 day  '));
                 }else{

                 $leasePeriodFrom = date('d-m-Y', strtotime($invoiceDueDate. ''));;
                 $leasePeriodTo = date('d-m-Y', strtotime($invoiceDueDate. ' + 1 year - 1 day'));

                 $prevPeriodFrom = '-';
                 $prevPeriodTo = '-';

                 $billDate = $start_date;
               }

               $model->current_total_dues = $model->current_lease_rent + $model->current_tax;

               $penalInterest = round((($diffDate  * ($interest->rate + 100 )/100) * $model->prev_dues_total ) / 365);
               if($penalInterest < 0 ){
                 $penalInterest = 0;
               }

               $leftOverAmount = $model->prev_dues_total;
               $previousDueTotal = $leftOverAmount + $penalInterest;


                 return $this->render('generate', [
                         'previousCGSTAmount' => $previousCGSTAmount,
                         'previousSGSTAmount' => $previousSGSTAmount,
                         'currentCGSTAmount' => $currentCGSTAmount,
                         'currentSGSTAmount' => $currentSGSTAmount,
                         'prevNotPaid' => $leftOverAmount,
                         'leasePeriodFrom' => $leasePeriodFrom,
                         'leasePeriodTo' => $leasePeriodTo,
                         'prevPeriodFrom' => $prevPeriodFrom,
                         'prevPeriodTo' => $prevPeriodTo,
                         'invoiceDueDate' => $invoiceDueDate,
                         'order_id' => $order_id,
                         'interest' => $interest,
                         'tax' => $tax,
                         'rate' => $rate,
                         'start_date' => $start_date,
                         'company' => $company,
                         'order' => $order,
                         'model' => $model,
                         'penalInterest' => $penalInterest,
                     ]);
              }
    }

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
            $start_date = $model->start_date;
            $invoiceDueDate = date('d-m-Y', strtotime($model->due_date. ' + 15 days'));

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

    public function actionUpdate()
    {
        // $inovice = Invoice::findOne($id);
        // $model = new MyInvoice();
        // $model->generate($inovice);

        MyInvoice::createInvoices();
        // if (\Yii::$app->user->can('updateInvoice')){
        //     $model = $this->findModel($id);
        //
        //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //         return $this->redirect(['view', 'id' => $model->invoice_id]);
        //     }
        //
        //     return $this->render('update', [
        //         'model' => $model,
        //     ]);
        // }else{
        //     throw new \yii\web\ForbiddenHttpException;
        // }
        return $this->render('invoice-generated');
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
