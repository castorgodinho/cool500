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
        $model_invoice = new Invoice();
        if ($model_invoice->load(Yii::$app->request->post())) {
          $model_payment = new Payment();
          $model = Invoice::find()->where(['invoice_code' => $model_invoice->invoice_code])->one();
            if(!$model){
                throw new \yii\web\ForbiddenHttpException;
            }
            $previousLeaseRent = $model_invoice->prev_lease_rent;
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

            date_default_timezone_set('Asia/Kolkata');
            $start_date = date('Y-m-d');

            $model_payment->start_date = $start_date;
            $model_payment->invoice_id = $model->invoice_id;
            $model_payment->mode = 'cash';
            $model_payment->order_id = $model->order_id;

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
                  'start_date' => $start_date,

                  'inovice' => $model_invoice,
                  'model' => $model_payment
              ]);
        }

        return $this->render('search', [
            'model' => $model_invoice,
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
