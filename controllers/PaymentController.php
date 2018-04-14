<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\SearchPayment;
use yii\web\Controller;
use app\models\Orders;
use app\models\Company;
use app\models\OrderDetails;
use app\models\Area;
use app\models\Plot;
use app\models\Tax;
use app\models\Interest;
use app\models\Rate;
use app\models\Invoice;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new SearchPayment();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        $invoice = $model->invoice;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'inovice' => $invoice,
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();

        if ($model->load(Yii::$app->request->post())) {
          $model->save();
        }

        return $this->render('view', [
            'model' => $this->findModel($model->payment_id),
        ]);
    }

    public function actionSearch()
    {
        $model_payment = new Payment();

        if ($model_payment->load(Yii::$app->request->post())) {

          $model = Invoice::findOne($model_payment->invoice_id);

          $previousLeaseRent = 0;
          $previousCGST = 0;
          $previousSGST = 0;
          $previousCGSTAmount = 0;
          $previousSGSTAmount = 0;
          $previousTotalTax = 0;
          $previousDueTotal = 0;
          $penalInterest = 0;

          $currentLeaseRent = 0;
          $currentCGSTAmount = 0;
          $currentSGSTAmount = 0;
          $currentSGST = 0;
          $currentSGST = 0;
          $currentTotalTax = 0;
          $currentDueTotal = 0;

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

          $currentCGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
          $currentSGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
          $currentSGST = ($tax->rate/2);
          $currentSGST = ($tax->rate/2);
          $currentTotalTax = $currentSGSTAmount + $currentCGSTAmount;
          $currentDueTotal = $currentLeaseRent + $currentTotalTax;

          $paymentCount = Payment::find()->where(['order_id' => $model->order_id])->count();

          $invoiceArray = Invoice::find()->where(['order_id' => $model->order_id])->all();
          if($paymentCount == 0){
            $previousDueTotal = 0;
          } else{
              $invoiceRate = $invoiceArray[0]->rate->rate;
              $invoiceTax = $invoiceArray[0]->tax->rate;
              $previousLeaseRent = $invoiceRate * $totalArea;
              $previousCGSTAmount = $previousLeaseRent * (($invoiceTax/2)/100);
              $previousSGSTAmount = $previousLeaseRent * (($invoiceTax/2)/100);
              $previousSGST = ($invoiceTax/2);
              $previousCGST = ($invoiceTax/2);
              $previousTotalTax =  $previousCGSTAmount + $previousCGSTAmount;
              foreach ($invoiceArray as $invoice) {
                $paymentArray = $invoice->payments;
                $invoiceTax = $invoice->tax->rate;
                $invoiceTotal = $invoiceRate * $totalArea;
                $invoiceTotal = $invoiceTotal + ( $invoiceTotal * ($invoiceTax/100));
                $previousDueTotal = $invoiceTotal;
                foreach ($paymentArray as $payment) {
                  $previousDueTotal = $previousDueTotal - $payment->amount;
                }
              }
          }
          $currentCGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
          $currentSGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
          $currentSGST = ($tax->rate/2);
          $currentCGST = ($tax->rate/2);
          $currentTotalTax = $currentSGSTAmount + $currentCGSTAmount;
          $currentDueTotal = $currentLeaseRent + $currentTotalTax;

          $penalInterest = ($interest->rate/100) * $previousDueTotal;
          $previousDueTotal = $previousDueTotal + $penalInterest;

          date_default_timezone_set('Asia/Kolkata');
          $start_date = date('Y-m-d');

          $model_payment->start_date = $start_date;
          $model_payment->mode = 'cash';
          $model_payment->order_id = $order->order_id;

          return $this->render('create', [
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

                  'rate' => $rate,
                  'tax' => $tax,
                  'order_id' => $order->order_id,
                  'interest' => $interest,
                  'start_date' => $start_date,

                  'inovice' => $model,
                  'model' => $model_payment
              ]);
        }

        return $this->render('search', [
            'model' => $model_payment,
        ]);
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->payment_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
