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
            $model->generate();
            if(! \Yii::$app->user->can('company')){
                return $this->redirect(['view', 'id' => $model->payment_id ]);
            }else{
                return $this->render('online-payment', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    public function actionRenderPayment($id){
        $model_payment = new MyPayment();
        $model = Invoice::find()
            ->where(['invoice_code' => $id])
            ->one();

        if(!$model){
            throw new \yii\web\ForbiddenHttpException;
        }

        date_default_timezone_set('Asia/Kolkata');
        $start_date = date('Y-m-d');

        $model_payment->start_date = $start_date;
        $model_payment->invoice_id = $model->invoice_id;
        $model_payment->mode = 'cash';
        $model_payment->order_id = $model->order_id;

        $totalPayment = Payment::find()
        ->where(['invoice_id' => $model->invoice_id])
        ->sum('amount');

        $pi = Payment::find()
        ->where(['invoice_id' => $model->invoice_id])
        ->sum('penal');

        $in = Invoice::find()
        ->where(['order_id' => $model->order_id])
        ->orderBy(['invoice_id' => SORT_DESC])
        ->one();

        if($in->invoice_id != $model->invoice_id){
          $balanceAmount = 0;
        }else{
            $balanceAmount = $model->grand_total - $totalPayment - $pi;
        }

        $tds_amount = Payment::find()
        ->where(['invoice_id' => $model->invoice_id])
        ->sum('tds_amount');

        date_default_timezone_set('Asia/Kolkata');
        $date1 = date('Y-m-d', strtotime($model->start_date. ' + 15 days'));
        $date2 = date('Y-m-d');
        $diff = strtotime($date2) - strtotime($date1);
        // $diff = strtotime($date1) - strtotime($date2);
        $diffDate  = $diff / (60*60*24);

        if($in->invoice_id != $model->invoice_id){
          $balanceAmount = 0;
        }else{
            $balanceAmount = $model->grand_total - $totalPayment - $pi;
        }

        $lease_rent = $in->current_lease_rent;
        $total_tax = $in->current_tax;

        $amount = $balanceAmount;
        $PenalInterestAmount = 0;

        $totalLeaseRentPaid = Payment::find()
        ->where(['invoice_id' => $model->invoice_id])
        ->sum('lease_rent');

        if( $diffDate > 0 ){

            $perDayPenalInterestAmount  = ($in->current_lease_rent - $totalLeaseRentPaid) * ($in->interest->rate/100)/365;
            $PenalInterestAmount  = round($perDayPenalInterestAmount * $diffDate) ;
            $model_payment->penalInterestAmount = $PenalInterestAmount;
            $model->current_interest = $model->current_interest + $PenalInterestAmount;
            $model->save(False);
            $balanceAmount = round($model->current_interest + $amount);
            /// '$balanceAmount '.$balanceAmount.'<br>';
            /// '$amount '.$amount.'<br>';
            /// '$PenalInterestAmount '.$PenalInterestAmount.'<br>';
        }

        if($balanceAmount < 0){
          $balanceAmount = 0;
        }

        return $this->render('create', [
                'start_date' => $start_date,
                'lease_rent' => $lease_rent,
                'total_tax' => $total_tax,
                'PenalInterestAmount' => $PenalInterestAmount,
                'amount' => $amount,
                'balanceAmount' => $balanceAmount,
                'tds_amount' => $tds_amount,
                'invoice' => $model,
                'model' => $model_payment,
                'diffDate' => $diffDate
        ]);
    }


    public function actionSearch()
    {
        if (\Yii::$app->user->can('searchInvoice')){
            $model_invoice = new Invoice();
            if ($model_invoice->load(Yii::$app->request->post()) /* || Yii::$app->request->get() */) {
                echo $model_invoice->invoice_code;
                return $this->redirect(['render-payment', 'id' => $model_invoice->invoice_code]);
                /* if(Yii::$app->request->get()){
                    $model_invoice->invoice_code = Yii::$app->getRequest()->getQueryParam('id');
                } */
                /* $model_payment = new MyPayment();
                $model = Invoice::find()
                    ->where(['invoice_code' => $model_invoice->invoice_code])
                    ->one();

                if(!$model){
                    throw new \yii\web\ForbiddenHttpException;
                }

                date_default_timezone_set('Asia/Kolkata');
                $start_date = date('Y-m-d');

                $model_payment->start_date = $start_date;
                $model_payment->invoice_id = $model->invoice_id;
                $model_payment->mode = 'cash';
                $model_payment->order_id = $model->order_id;

                $totalPayment = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('amount');

                $pi = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('penal');

                $in = Invoice::find()
                ->where(['order_id' => $model->order_id])
                ->orderBy(['invoice_id' => SORT_DESC])
                ->one();

                if($in->invoice_id != $model->invoice_id){
                  $balanceAmount = 0;
                }else{
                    $balanceAmount = $model->grand_total - $totalPayment - $pi;
                }

                $tds_amount = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('tds_amount');

                date_default_timezone_set('Asia/Kolkata');
                $date1 = date('Y-m-d', strtotime($model->start_date. ' + 15 days'));
                $date2 = date('Y-m-d');
                $diff = strtotime($date2) - strtotime($date1);
                // $diff = strtotime($date1) - strtotime($date2);
                $diffDate  = $diff / (60*60*24);

                if($in->invoice_id != $model->invoice_id){
                  $balanceAmount = 0;
                }else{
                    $balanceAmount = $model->grand_total - $totalPayment - $pi;
                }

                $lease_rent = $in->current_lease_rent;
                $total_tax = $in->current_tax;

                $amount = $balanceAmount;
                $PenalInterestAmount = 0;

                $totalLeaseRentPaid = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('lease_rent');

                if( $diffDate > 0 ){

                  $perDayPenalInterestAmount  = ($in->current_lease_rent - $totalLeaseRentPaid) * ($in->interest->rate/100)/365;
                  $PenalInterestAmount  = round($perDayPenalInterestAmount * $diffDate) ;
                  $model_payment->penalInterestAmount = $PenalInterestAmount;
                  $model->current_interest = $model->current_interest + $PenalInterestAmount;
                  $model->save(False);
                  $balanceAmount = round($model->current_interest + $amount);
                  /// '$balanceAmount '.$balanceAmount.'<br>';
                  /// '$amount '.$amount.'<br>';
                  /// '$PenalInterestAmount '.$PenalInterestAmount.'<br>';
                }

                if($balanceAmount < 0){
                  $balanceAmount = 0;
                }

                return $this->render('create', [
                        'start_date' => $start_date,
                        'lease_rent' => $lease_rent,
                        'total_tax' => $total_tax,
                        'PenalInterestAmount' => $PenalInterestAmount,
                        'amount' => $amount,
                        'balanceAmount' => $balanceAmount,
                        'tds_amount' => $tds_amount,
                        'invoice' => $model,
                        'model' => $model_payment,
                        'diffDate' => $diffDate
                ]); */

          }else{
            return $this->render('search', [
                'model' => $model_invoice,
            ]);
          }
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
