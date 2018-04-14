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

        if (\Yii::$app->user->can('indexOrders')){
            $searchModel = new SearchOrders();
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
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewOrders')){
            $model = $this->findModel($id);
            $plots = OrderDetails::find()->where(['order_id' => $id]);
            $orders = Orders::find()->where(['order_id' => $id])->all();

            $dataProvider = new ActiveDataProvider([
                'query' => $plots,
            ]);
            return $this->render('view', [
                'model' =>  $model,
                'plots' => $dataProvider,
                'orders' => $orders,
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createOrders')){
            $model = new Orders();
            $company = Company::find()->all();
            $area = Area::find()->all();
            $orderDetails = new OrderDetails();
            if ($model->load(Yii::$app->request->post()) && $orderDetails->load(Yii::$app->request->post())) {
                /* echo $model->order_number.'-<br>';
                echo $model->company_id.'-<br>';
                echo $model->built_area.'-<br>';
                echo $model->shed_area.'-<br>';
                echo $model->godown_area.'-<br>';
                echo $model->start_date.'-<br>';
                echo $model->end_date.'-<br>';
                echo $model->shed_no.'-<br>';
                echo $model->godown_no.'-<br>';
                echo $model->area_id.'-<br>';
                echo $model->total_area.'-<br>'; */
                $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($model->area->name);
                while(Orders::find()->where(['order_number' => $orderNumber])->count() != 0){
                    $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($model->area->name);
                }
                $model->order_number = $orderNumber;
                $model->save();
                for($i = 0; $i < sizeof($orderDetails->plot_id); $i++){
                    $detail = new OrderDetails();
                    $plot = new Plot();
                    $plot->name = $orderDetails->plot_id[$i];
                    $plot->area_id = $model->area_id;
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
        }else{
            throw new \yii\web\ForbiddenHttpException;
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
        if ($model->load(Yii::$app->request->post())) {
          $invoiceCode = '';
          echo '$model->rate_id '.$model->rate_id.'<br>';
          echo '$model->tax_id '.$model->tax_id.'<br>';
          echo '$model->order_id '.$model->order_id.'<br>';
          echo '$model->interest_id '.$model->interest_id.'<br>';
          echo '$model->total_amount '.$model->total_amount.'<br>';
          echo '$model->start_date '.$model->start_date.'<br>';
          $model->total_amount = round($model->total_amount);
          $order =  Orders::findOne($id);
          $orderPlotArray = $order->plots;
          foreach ($orderPlotArray as $plot) {
            $area = $plot->area;
          }
          $areaCode = strtoupper(substr($area->name,0,3));
          $invoiceCode = $areaCode .'/';
          date_default_timezone_set('Asia/Kolkata');
          $year = date('Y');
          $year = substr($year,2,3);
          $invoiceCode = $areaCode . '/' . $year;
          echo '$invoiceCode '.$invoiceCode.'<br>';
          $year = intval($year) + 1;
          $invoiceCode = $invoiceCode . '-' . $year;
          echo '$year '.$year.'<br>';
          echo '$areaCode '.$areaCode.'<br>';
          echo '$invoiceCode '.$invoiceCode.'<br>';
          $model->invoice_code = 'hello';
          $model->save();
          $invoiceID = strval($model->invoice_id);
          echo 'sizeof($invoiceID) '.sizeof($invoiceID).'<br>';
          for ($i=0; $i < 5- sizeof($invoiceID); $i++) {
            $invoiceID = '0'. $invoiceID;
            echo '$invoiceCode '.$invoiceID.'<br>';
          }
          $invoiceCode = $invoiceCode . '/' . $invoiceID;
          echo '$invoiceCode '.$invoiceCode.'<br>';
          $model->invoice_code = $invoiceCode;
          $model->save();
          return $this->redirect(['invoice/index']);
        } else{
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

                  'company' => $company,
                  'order' => $order,    
                  'model' => $model,
              ]);
        }



        // if (\Yii::$app->user->can('updateOrders')){
        //     $model =  Orders::find()->where(['order_id' => $id])->all();
        //     $company = Company::find()->all();
        //     $area = Area::find()->all();
        //     $orderDetails = OrderDetails::find()->where(['order_id' => $id])->all();
        //     if ($model->load(Yii::$app->request->post()) && $orderDetails->load(Yii::$app->request->post())) {
        //         $model->save();
        //         for($i = 0; $i < sizeof($orderDetails->plot_id); $i++){
        //             $detail = new OrderDetails();
        //             $plot = new Plot();
        //             $plot->name = $orderDetails->plot_id[$i];
        //             $plot->save(false);
        //             $detail->order_id = $model->order_id;
        //             $detail->plot_id = $plot->plot_id;
        //             $detail->save(false);
        //         }
        //         return $this->redirect(['orders/index']);
        //     } else {
        //         return $this->render('update', [
        //             'model' => $model,
        //             'company' => $company,
        //             'area' => $area,
        //             'orderDetails' => $orderDetails,
        //         ]);
        //     }
        // }else{
        //     throw new \yii\web\ForbiddenHttpException;
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
        if (\Yii::$app->user->can('deleteOrders')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
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
