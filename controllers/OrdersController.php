<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\Area;
use app\models\Plot;
use app\models\OrderRate;
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
            $orderRate = new OrderRate();
            $company = Company::find()->all();
            $area = Area::find()->all();
            if ($model->load(Yii::$app->request->post()) && $orderRate->load(Yii::$app->request->post())) {
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

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if (\Yii::$app->user->can('updateOrders')){
            $model =  Orders::find()->where(['order_id' => $id])->all();
            $company = Company::find()->all();
            $area = Area::find()->all();
            $orderDetails = OrderDetails::find()->where(['order_id' => $id])->all();
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
                return $this->render('update', [
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
