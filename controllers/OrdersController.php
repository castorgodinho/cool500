<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
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
            $orders = Orders::find()->where(['order_id' => $id])->all();
            return $this->render('view', [
                'model' =>  $model,
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
            if ($model->load(Yii::$app->request->post())) {
                $area_update = Area::find()->where(['area_id' => $model->area_id])->one();
                $area_update->total_area = $area_update->total_area + $model->total_area;
                $area_update->save();
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
                $names = explode(" ", $model->area->name);
                $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($names[0]);
                while(Orders::find()->where(['order_number' => $orderNumber])->count() != 0){
                    $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($names[0]);
                }
                //echo $model->built_area;
                $model->order_number = $orderNumber;
                 $model->save();
                return $this->redirect(['orders/index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'company' => $company,
                    'area' => $area,
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
          $model->total_amount = round($model->total_amount);
          $order =  Orders::findOne($id);
          $time = strtotime($order->start_date);
          $area = $model->order->area;
          $areaCode = strtoupper(substr($area->name,0,3));
          $invoiceCode = $areaCode .'/';
          date_default_timezone_set('Asia/Kolkata');
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
          $model->save(False);
          return $this->redirect(['invoice/index']);
        } else{

            date_default_timezone_set('Asia/Kolkata');
            $start_date = date('d-m-Y');
            $diffDate = 0;

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

             $tax = Tax::find()
             ->where(['name' => 'GST'])
             ->where(['flag' => 1])
             ->one();

             $interest = Interest::find()
             ->where(['name' => 'Penal Interest'])
             ->andWhere(['flag' => 1])
             ->one();

             $area = $order->area;

             $rate = Rate::find()->where(['area_id' => $area->area_id])
             ->andWhere(['flag' => 1])
             ->one();

             $currentLeaseRent   = $rate->rate * $totalArea;
             $taxAmout = $currentLeaseRent * ($tax->rate/100);
             $currentCGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
             $currentSGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
             $currentSGST = ($tax->rate/2);
             $currentSGST = ($tax->rate/2);
             $currentTotalTax = $currentSGSTAmount + $currentCGSTAmount;
             $currentDueTotal = $currentLeaseRent + $currentTotalTax;

             $invoice = Invoice::find()
             ->where(['order_id' => $id])
             ->orderBy(['invoice_id' => SORT_DESC])
             ->one();

             if($invoice){
               $totalPaid = Payment::find()
               ->where(['invoice_id' => $invoice->invoice_id])
               ->sum('amount');

               $pi = Payment::find()
               ->where(['invoice_id' => $invoice->invoice_id])
               ->sum('penal');

               $previousDueTotal = $invoice->grand_total - $totalPaid;
             }

             $totalInvoiceAmount = Invoice::find()
             ->where(['order_id' => $id])
             ->sum('grand_total');

             date_default_timezone_set('Asia/Kolkata');
             $currentDate = date('d-m-Y');

             $totalAmount = 0;
             if($invoice){
             $previousLeaseRent = $invoice->current_lease_rent;
             $previousCGST = 9;
             $previousSGST = 9;
             $previousCGSTAmount =  $invoice->current_tax/2;
             $previousSGSTAmount =  $invoice->current_tax/2;
             $previousTotalTax = $invoice->current_tax;

             $order =  Orders::findOne($id);
             $time = strtotime($invoice->start_date);
             $newformat = date('d-m-Y',$time);
             $invoiceDueDate = date('d-m-Y', strtotime($newformat. ' + 1 year 15 days'));
             $billDate = $currentDate;
             // $billDate = date('d-m-Y', strtotime($newformat. ' 1 year'));

             $date1 = $invoiceDueDate;
             $date2 = $start_date;
             $diff = strtotime($date2) - strtotime($date1);
             $diffDate  = $diff / (60*60*24);

             }else{
             $time = strtotime($order->start_date);
             $newformat = date('d-m-Y',$time);
             $invoiceDueDate = date('d-m-Y', strtotime($newformat. ' + 15 days'));
             $billDate = $currentDate;
            }

             $currentCGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
             $currentSGSTAmount = $currentLeaseRent * (($tax->rate/2)/100);
             $currentSGST = ($tax->rate/2);
             $currentCGST = ($tax->rate/2);
             $currentTotalTax = $currentSGSTAmount + $currentCGSTAmount;
             $currentDueTotal = $currentLeaseRent + $currentTotalTax;

             $penalInterest = round((($diffDate  * ($interest->rate + 100 )/100) * $previousDueTotal ) / 365);
             if($penalInterest < 0 ){
               $penalInterest = 0;
             }

             $leftOverAmount = $previousDueTotal;
             echo $leftOverAmount;
             $previousDueTotal = $leftOverAmount + $penalInterest;

             $leasePeriodFrom = date('d-m-Y', strtotime($invoiceDueDate. ''));;
             $leasePeriodTo = date('d-m-Y', strtotime($invoiceDueDate. ' + 1 year - 1 day'));

             if($previousLeaseRent == 0){
               $prevPeriodFrom = '-';
               $prevPeriodTo = '-';
             }else{
               $prevPeriodFrom = date('d-m-Y', strtotime($leasePeriodFrom. ' - 1 year '));
               $prevPeriodTo   = date('d-m-Y', strtotime($leasePeriodFrom. ' - 1 day  '));
             }

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
                     'prevNotPaid' => $leftOverAmount,

                     'leasePeriodFrom' => $leasePeriodFrom,
                     'leasePeriodTo' => $leasePeriodTo,

                     'prevPeriodFrom' => $prevPeriodFrom,
                     'prevPeriodTo' => $prevPeriodTo,

                     'billDate' => $billDate,
                     'invoiceDueDate' => $invoiceDueDate,

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
