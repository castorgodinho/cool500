<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
use app\models\OrderDetails;
use app\models\Area;
use app\models\Plot;
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
