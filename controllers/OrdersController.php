<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\Company;
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
        $searchModel = new SearchOrders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $plots = Orders::find()->where(['order_number' => $model->order_number]);
        $dataProvider = new ActiveDataProvider([
            'query' => $plots,
        ]);
        return $this->render('view', [
            'model' =>  $model,
            'plots' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();
        $company = Company::find()->all();
        $area = Area::find()->all();
        $plot = Plot::find()->where(['not in','plot_id', Orders::find()->all()])->all();
        if ($model->load(Yii::$app->request->post())) {
            for($i = 0; $i < sizeof($model->plot_id); $i++){
                echo $model->plot_id[$i];
                $order = new Orders();
                $order->order_number = $model->order_number;
                $order->company_id = $model->company_id;
                $order->start_date = $model->start_date;
                $order->plot_id = $model->plot_id[$i];
                $order->built_area = $model->built_area[$i];
                $order->shed_area = $model->shed_area[$i];
                $order->godown_area = $model->godown_area[$i];
                $order->save();
            }
            return $this->redirect(['orders/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'company' => $company,
                'plot' => $plot,
                'area' => $area,
            ]);
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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