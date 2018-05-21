<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\Area;
use app\models\Plot;
use app\models\Log;
use app\models\OrderRate;
use app\models\Tax;
use yii\helpers\Json;
use yii\web\UploadedFile;
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
            $orderRate = new OrderRate();
            $company = Company::find()->all();
            $area = Area::find()->all();
            if ($model->load(Yii::$app->request->post()) && $orderRate->load(Yii::$app->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file){
                    $model->upload();
                }
                $area_update = Area::find()->where(['area_id' => $model->area_id])->one();
                $area_update->total_area = $area_update->total_area + $model->total_area;
                $area_update->save();
                $names = explode(" ", $model->area->name);
                $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($names[0]);
                while(Orders::find()->where(['order_number' => $orderNumber])->count() != 0){
                    $orderNumber = 'GIDC'. sprintf("%06d", rand(1, 1000000)) . strtoupper($names[0]);
                }
                //echo $model->built_area;
                if(strlen($orderNumber) > 15){
                    $model->order_number = substr($orderNumber, 0, 15);
                }else{
                    $model->order_number = $orderNumber;
                }
                $model->save();
                $orderRate->order_id = $model->order_id;
                $orderRate->flag = '1';
                $orderRate->save();
                return $this->redirect(['orders/index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'company' => $company,
                    'area' => $area,
                    'orderRate' => $orderRate,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    public function actionTransfer($id){
        if (\Yii::$app->user->can('updateOrders')){
            $model =  Orders::find()->where(['order_id' => $id])->one();
            $company = Company::find()->all();
            $orderRate = OrderRate::find()->where(['order_id' => $id])->andWhere(['flag' => 1])->one();
            $area = Area::find()->all();
            if ($model->load(Yii::$app->request->post()) && $orderRate->load(Yii::$app->request->post())) {
                $oldOrder = Orders::findOne($model->order_id);
                
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file){
                    $model->upload();
                }
                $model->transfer_file = UploadedFile::getInstance($model, 'transfer_file');
                if($model->transfer_file){
                    echo "Transfered!";
                    $model->uploadTranfer();
                }
                $newOrder = new Orders();
                $newOrder->order_number = $model->order_number;
                $newOrder->company_id = $model->company_id;
                $newOrder->built_area = $model->built_area;
                $newOrder->shed_area = $model->shed_area;
                $newOrder->godown_area = $model->godown_area;
                $newOrder->start_date = $model->start_date;
                $newOrder->end_date = $model->end_date;
                $newOrder->shed_no = $model->shed_no;
                $newOrder->godown_no = $model->godown_no;
                $newOrder->area_id = $model->area_id;
                $newOrder->total_area = $model->total_area;
                $newOrder->plots = $model->plots;
                $newOrder->document = $model->document;
                $newOrder->transfer_url = $model->transfer_url;
                $newOrder->save();
                $oldOrder->next_order_id = $newOrder->order_id;
                $oldOrder->status = 0;
                $oldOrder->save();
                //$model->save();
                $newOrderRate = new OrderRate();
                $newOrderRate->order_id = $newOrder->order_id;
                $newOrderRate->start_date = $orderRate->start_date;
                $newOrderRate->end_date= $orderRate->end_date;
                $newOrderRate->amount1= $orderRate->amount1;
                $newOrderRate->amount2= $orderRate->amount2;
                $newOrderRate->flag = 1;
                $newOrderRate->save(false);
                return $this->redirect(['orders/index']);
            } else {
                return $this->render('transfer', [
                    'model' => $model,
                    'company' => $company,
                    'area' => $area,
                    'orderRate' => $orderRate,
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

        if (\Yii::$app->user->can('updateOrders')){
            $model =  Orders::find()->where(['order_id' => $id])->one();
            $company = Company::find()->all();
            $orderRate = OrderRate::find()->where(['order_id' => $id])->andWhere(['flag' => 1])->one();
            $area = Area::find()->all();
            if ($model->load(Yii::$app->request->post()) && $orderRate->load(Yii::$app->request->post())) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if($model->file){
                    $model->upload();
                }
                $model->transfer_file = UploadedFile::getInstance($model, 'transfer_file');
                if($model->transfer_file){
                    echo "Transfered!";
                    $model->uploadTranfer();
                }
                $log = new Log();
                $log->old_value = Json::encode(Orders::find()->where(['order_id' => $id])->all(), $asArray = true) ;
                $model->save();
                $log->new_value = Json::encode(Orders::find()->where(['order_id' => $id])->all(), $asArray = true) ;
                $log->user_id = Yii::$app->user->identity->user_id;
                $log->type = 'Edited Unit';
                $log->save();
                
                $oldOrderRate = OrderRate::find()->where(['order_id' => $id])->andWhere(['flag' => 1])->one();
                if($oldOrderRate->start_date != $orderRate->start_date || $oldOrderRate->end_date != $orderRate->end_date || $oldOrderRate->amount1 != $orderRate->amount1 || $oldOrderRate->amount2 != $orderRate->amount2){
                    //Creating new orderRate
                    echo "Came here..";
                    $oldOrderRate->flag = 0;
                    $oldOrderRate->save(false);
                    $rate = new OrderRate();
                    $rate->start_date = $orderRate->start_date;
                    $rate->end_date = $orderRate->end_date;
                    $rate->amount1 = $orderRate->amount1;
                    $rate->amount2 = $orderRate->amount2;
                    $rate->order_id = $id;
                    $rate->flag = 1;
                    $rate->save(false);

                }
                return $this->redirect(['orders/index']);
            } else {
                return $this->render('_form', [
                    'model' => $model,
                    'company' => $company,
                    'area' => $area,
                    'orderRate' => $orderRate,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }

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
