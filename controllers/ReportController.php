<?php

namespace app\controllers;

use Yii;
use app\models\Rate;
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
        if (\Yii::$app->user->can('indexInvoice')){
            $model = new InvoiceSearchData();
            if($model->load(Yii::$app->request->post())){
                $dataProvider = '';
                $searchModel = new InvoiceReport();
                $searchModel->from_date = $model->from_date;
                $searchModel->to_date = $model->to_date;
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
}
