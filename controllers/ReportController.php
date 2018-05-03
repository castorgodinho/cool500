<?php

namespace app\controllers;

use Yii;
use app\models\Rate;
use app\models\Payment;
use app\models\SearchRate;
use app\models\Log;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Invoice;
use app\models\InvoiceReport;
use app\models\InvoiceSearchData;

/**
 * RateController implements the CRUD actions for Rate model.
 */
class ReportController extends Controller
{
    public function actionInvoiceReport(){
        if (\Yii::$app->user->can('viewInvoiceReport')){
            $model = new InvoiceSearchData();
            if($model->load(Yii::$app->request->post())){
                $dataProvider = '';
                $searchModel = new InvoiceReport();
                $searchModel->from_date = $model->from_date;
                $searchModel->to_date = $model->to_date;
                $searchModel->search_key = $model->search_key;
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                
            }else{
                echo "didngt load";
                $searchModel = new InvoiceReport();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                
            }
            return $this->render('invoice-report', [
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
            
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }
    public function actionView($id)
    {
        return $this->redirect([
            'invoice/view', 'id' => $id
        ]);
    }

    public function actionLedger()
    {
        if (\Yii::$app->user->can('viewLedgerReport')){
            $invoice = '';
            $payment = '';
            $to = 'Records';
            $from = 'All';
            if(Yii::$app->request->post()){
                echo "Here";
                $to = Yii::$app->request->post('to_date');
                $from = Yii::$app->request->post('from_date');
                if($to != '' && $from != ''){
                    echo 'Query with dates';
                    $invoice = Invoice::find()->orderBy('start_date')
                    ->where(['between', 'start_date', $from, $to ])->all();
                    $payment = Payment::find()->orderBy('start_date')
                    ->where(['between', 'start_date', $from, $to ])->all();
                }else{
                    echo 'Query without dates';
                    $invoice = Invoice::find()->orderBy('start_date')->all();
                    $payment = Payment::find()->orderBy('start_date')->all(); 
                }
            }else{
                echo 'Normal';
                $invoice = Invoice::find()->orderBy('start_date')->all();
                $payment = Payment::find()->orderBy('start_date')->all();
            }
            return $this->render(
                'ledger',
                [
                    'invoice' => $invoice,
                    'payment' => $payment,
                    'to' => $to,
                    'from' => $from,
                ]
            );
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
        
    }
}
