<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\MyPayment;
use app\models\Debit;
use app\models\SearchPayment;
use yii\web\Controller;
use app\models\Orders;
use app\models\Company;
use app\models\Area;
use app\models\Plot;
use app\models\Tax;
use app\models\ReportSearch;
use app\models\Interest;
use app\models\Rate;
use app\models\Invoice;
use app\models\MyInvoice;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
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
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexPayment')){
            $searchModel = new SearchPayment();
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
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Payment::findOne($id);
        if (\Yii::$app->user->can('viewPayment', ['payment' => $model])){
            $invoice = $model->invoice;
              $debit = Debit::find()->where(['payment_id' => $model->payment_id])->one();
            return $this->render('view', [
                'model' => $this->findModel($id),
                'invoice' => $invoice,
                'debit' => $debit,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('admin') || \Yii::$app->user->can('company')){
            $model = new MyPayment();
            if(! \Yii::$app->user->can('company')){
                $model->generatePayment('1',$this);
                return $this->redirect(['view', 'id' => $model->payment_id ]);
            }else{
                $model->generatePayment('0',$this);
                return $this->render('online-payment', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }


    public function actionRenderPayment($id){
        date_default_timezone_set('Asia/Kolkata');
        $model = new MyPayment();
        $invoice = Invoice::find()->where(['invoice_code' => $id])->one();
        $order = $invoice->order;
        $interest =  MyInvoice::getCurrentInterest();
        if(!$model){
            throw new \yii\web\ForbiddenHttpException;
        }
        $totalAmount = MyInvoice::getTotalAmount($order);
        $totalAmountPaid = MyPayment::getTotalAmountPaid($order);
        $totalPenal = MyInvoice::getTotalPenal($order);
        $totalPenalPaid = MyInvoice::getTotalPenalPaid($order);
        $diffDate  = MyInvoice::getDateDifference($invoice->due_date); //TODO
        //$diffDate  = 100;
        $totalLeaseRent = MyInvoice::getTotalLeaseRent($order);
        $totalLeaseRentPaid = MyInvoice::getTotalLeaseRentPaid($order);
        $totalTaxPaid = MyInvoice::getTotalTaxPaid($order);
        $totalTax = MyInvoice::getTotalTax($order);
        $penalAmount = 0;
        if( $diffDate > 0 ){
          $penalAmount = MyPayment::calculatePenalInterest($order,$interest,$diffDate);
        }
        $model->start_date = date('Y-m-d');
        $model->invoice_id = $invoice->invoice_id;
        $model->order_id = $order->order_id;
        $model->penal = $penalAmount;
        $model->lease_rent = $totalLeaseRent - $totalLeaseRentPaid;
        $model->tax = $totalTax - $totalTaxPaid;
        $balancePenal = $totalPenal + $penalAmount - $totalPenalPaid;
        $balanceAmount = $totalAmount - $totalAmountPaid + $balancePenal +   $totalPenalPaid;
        return $this->render('create', [
                'invoice' => $invoice,
                'balanceAmount' => $balanceAmount,
                'model' => $model,
        ]);
    }


    public function actionSearch()
    {
        if (\Yii::$app->user->can('searchInvoice')){
            $model_invoice = new Invoice();
            if ($model_invoice->load(Yii::$app->request->post())) {  /* || Yii::$app->request->get() */
                echo $model_invoice->invoice_code;
                return $this->redirect(['render-payment', 'id' => $model_invoice->invoice_code]);
          }else{
            return $this->render('search', [
                'model' => $model_invoice,
            ]);
          }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    public function actionCompletePayment($id){
        $payment = Payment::findOne($id);
        if (\Yii::$app->user->can('viewPayment', ['payment' => $payment])){
            $response = Yii::$app->getRequest()->getQueryParam('response');
            $transaction_id = Yii::$app->getRequest()->getQueryParam('transaction_id');
            echo $response;
            $payment->transaction_details = $response;
            $payment->transaction_no = $transaction_id;
            $payment->status = 1;
            $payment->save(false);
            return $this->redirect(['view', 'id' => $id ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updatePayment')){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->payment_id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deletePayment')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionOnline($id){
        $invoice = Invoice::findOne($id);
        return $this->render('online-payment',[
            'model' => $invoice,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
