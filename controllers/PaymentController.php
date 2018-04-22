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
            return $this->render('view', [
                'model' => $this->findModel($id),
                'inovice' => $invoice,
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
        if (\Yii::$app->user->can('createPayment')){
            $model = new Payment();

            if ($model->load(Yii::$app->request->post())) {
                $totalPayment = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('amount');
                $balanceAmount = $model->invoice->grand_total - $totalPayment - $model->amount;
                if($balanceAmount < 0){
                    Yii::$app->session->setFlash('danger', "TRYING TO PAY EXTRA");
                    return $this->redirect(['index']);
                }
                else if($model->tds_rate > 10.10 ){
                  Yii::$app->session->setFlash('danger', "TDS HAS TO BE LESS THAN 10.10");
                  return $this->redirect(['index']);
                }
                else{
                    $model->save(False);
                    $model->file = UploadedFile::getInstance($model, 'file');
                    if($model->file){
                      $model->tds_file = 'gstfiles/' . $model->payment_id . '.' . $model->file->extension;
                      $model->file->saveAs('gstfiles/' . $model->payment_id . '.' . $model->file->extension);
                    }                  
                    $lr = $model->invoice->current_lease_rent;
                    $tds_amount = ($lr * ($model->tds_rate/100));
                    $model->tds_amount = $tds_amount;
                    $model->save(False);
                }
            }
            return $this->redirect(['view', 'id' => $model->payment_id ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    public function actionSearch()
    {
        if (\Yii::$app->user->can('searchInvoice')){
            $model_invoice = new Invoice();
            if ($model_invoice->load(Yii::$app->request->post())) {
            $model_payment = new Payment();
            $model = Invoice::find()->where(['invoice_code' => $model_invoice->invoice_code])->one();

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

                $in = Invoice::find()
                ->where(['order_id' => $model->order_id])
                ->orderBy(['invoice_id' => SORT_DESC])
                ->one();

                if($in->invoice_id != $model->invoice_id){
                  $balanceAmount = 0;
                }else{
                    $balanceAmount = $model->grand_total - $totalPayment;
                }

                $tds_amount = Payment::find()
                ->where(['invoice_id' => $model->invoice_id])
                ->sum('tds_amount');

            return $this->render('create', [
                    'start_date' => $start_date,
                    'balanceAmount' => $balanceAmount,
                    'tds_amount' => $tds_amount,
                    'invoice' => $model,
                    'model' => $model_payment
                ]);
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
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
