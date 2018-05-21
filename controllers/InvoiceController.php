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

    public $sentFrom = 'castorgodinho22@gmail.com';
    public $serverLocation = 'http://localhost/gidc/';

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
              $order =  Orders::findOne($order_id);
              $invoice = MyInvoice::generateInvoice($order);
              return $this->redirect(['view','id' => $invoice->invoice_id]);
    }


    public function actionMail($id){
        if (\Yii::$app->user->can('admin')){
            $model = Invoice::findOne($id);
            $interest = $model->interest->rate;
            $toDate = date('d-m-Y', strtotime($model->due_date. ' + 1 year - 1 day'));
            $msg = "Dear Customer \n\nYour Lease Rent form the period $model->due_date - $toDate ".
                "is due on $model->due_date.I kindly request you to pay the same on or before due".
                 "date.delay payment will charge $interest% penal interest on daily basis.".
                "Please find copy of invoice for more details.\n\n".$this->serverLocation."/web/index.php?r=invoice%2Fview&id=".$model->invoice_id;
            $status = 0;
            try{
                $status = Yii::$app->mailer->compose()
                    ->setFrom($this->sentFrom)
                    ->setTo($model->order->company->user->email)
                    ->setSubject('IDC Goa')
                    ->setTextBody($msg)
                    ->send();
            }catch(\Swift_TransportException $e){
                $response = $e->getMessage() ;
            }catch(\Exception $e){
                echo "Mail failed";
            }
            $model->email_status = $status;
            $model->save(false);
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
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
            $start_date = date('d-m-Y', strtotime($model->start_date. ''));
            $invoiceDueDate = date('d-m-Y', strtotime($model->due_date. ''));

            $leasePeriodFrom = date('d-m-Y', strtotime($model->lease_current_start. ''));
            $leasePeriodTo = date('d-m-Y', strtotime($leasePeriodFrom. ' + 1 year - 1 day'));
            $prevPeriodFrom = '-';
            $prevPeriodTo = '-';
            if($model->lease_prev_start){
                $prevPeriodFrom = date('d-m-Y', strtotime($model->lease_prev_start. ' '));
                $prevPeriodTo = date('d-m-Y', strtotime($model->lease_prev_start. ' + 1 year - 1 day'));
            }

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
                  $model->save(False);

                return $this->redirect(['view','id' =>$model->invoice_id ]);
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

         MyInvoice::createInvoices();
        //MyInvoice::generateInvoiceCode('VER');

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
            $invoice = Invoice::findOne($id);
            $invoice->flag = '0';
            $invoice->save(False);
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
