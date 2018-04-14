<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\OrderDetails;
use app\models\Area;
use app\models\Plot;
use app\models\Tax;
use app\models\Invoice;
use app\models\Interest;
use app\models\Payment;
use app\models\Rate;
use app\models\SearchOrders;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchOrders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $plots = OrderDetails::find()->where(['order_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $plots,
        ]);
        return $this->render('view', [
            'model' =>  $model,
            'plots' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();
        $company = Company::find()->all();
        $area = Area::find()->all();
        $orderDetails = new OrderDetails();
        if ($model->load(Yii::$app->request->post()) && $orderDetails->load(Yii::$app->request->post())) {
            $model->save();
            for($i = 0; $i < sizeof($orderDetails->plot_id); $i++){
                $detail = new OrderDetails();
                $plot = new Plot();
                $plot->name = $orderDetails->plot_id[$i];
                $plot->save(false);
                $detail->order_id = $model->order_id;
                $detail->plot_id = $plot->plot_id;
                $detail->save(false);
            }
            return $this->redirect(['orders/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'company' => $company,
                'area' => $area,
                'orderDetails' => $orderDetails,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new Invoice();

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

        $order =  Orders::findOne($id);

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

        $paymentCount = Payment::find()->where(['order_id' => $id])->count();
        $invoiceArray = Invoice::find()->where(['order_id' => $id])->all();
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

        return $this->render('update', [
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
                'order_id' => $id,
                'interest' => $interest,
                'start_date' => $start_date,

                'model' => $model,
            ]);


        // $model =  Orders::find()->where(['order_id' => $id])->all();
        // $company = Company::find()->all();
        // $area = Area::find()->all();
        // $orderDetails = OrderDetails::find()->where(['order_id' => $id])->all();
        // if ($model->load(Yii::$app->request->post()) && $orderDetails->load(Yii::$app->request->post())) {
        //     $model->save();
        //     for($i = 0; $i < sizeof($orderDetails->plot_id); $i++){
        //         $detail = new OrderDetails();
        //         $plot = new Plot();
        //         $plot->name = $orderDetails->plot_id[$i];
        //         $plot->save(false);
        //         $detail->order_id = $model->order_id;
        //         $detail->plot_id = $plot->plot_id;
        //         $detail->save(false);
        //     }
        //     return $this->redirect(['orders/index']);
        // } else {
        //     return $this->render('update', [
        //         'model' => $model,
        //         'company' => $company,
        //         'area' => $area,
        //         'orderDetails' => $orderDetails,
        //     ]);
        // }
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
