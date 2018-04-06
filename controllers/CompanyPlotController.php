<?php

namespace app\controllers;

use Yii;
use app\models\CompanyPlot;
use app\models\SearchCompanyPlot;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyPlotController implements the CRUD actions for CompanyPlot model.
 */
class CompanyPlotController extends Controller
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
     * Lists all CompanyPlot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCompanyPlot();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompanyPlot model.
     * @param integer $company_id
     * @param integer $plot_id
     * @param string $start_date
     * @return mixed
     */
    public function actionView($company_id, $plot_id, $start_date)
    {
        return $this->render('view', [
            'model' => $this->findModel($company_id, $plot_id, $start_date),
        ]);
    }

    /**
     * Creates a new CompanyPlot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyPlot();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'company_id' => $model->company_id, 'plot_id' => $model->plot_id, 'start_date' => $model->start_date]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CompanyPlot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $company_id
     * @param integer $plot_id
     * @param string $start_date
     * @return mixed
     */
    public function actionUpdate($company_id, $plot_id, $start_date)
    {
        $model = $this->findModel($company_id, $plot_id, $start_date);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'company_id' => $model->company_id, 'plot_id' => $model->plot_id, 'start_date' => $model->start_date]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CompanyPlot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $company_id
     * @param integer $plot_id
     * @param string $start_date
     * @return mixed
     */
    public function actionDelete($company_id, $plot_id, $start_date)
    {
        $this->findModel($company_id, $plot_id, $start_date)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompanyPlot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $company_id
     * @param integer $plot_id
     * @param string $start_date
     * @return CompanyPlot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($company_id, $plot_id, $start_date)
    {
        if (($model = CompanyPlot::findOne(['company_id' => $company_id, 'plot_id' => $plot_id, 'start_date' => $start_date])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
