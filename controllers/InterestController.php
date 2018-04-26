<?php

namespace app\controllers;

use Yii;
use app\models\Interest;
use app\models\SearchInterest;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Log;
use yii\helpers\Json;

/**
 * InterestController implements the CRUD actions for Interest model.
 */
class InterestController extends Controller
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
     * Lists all Interest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchInterest();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Interest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Interest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Interest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->interest_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Interest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $interest = new Interest();
        if ($interest->load(Yii::$app->request->post())) {
            $model = $this->findModel($id);
            $model->flag = 0;
            $model->save();
            date_default_timezone_set('Asia/Kolkata');
            $interest->start_date = date('Y-m-d');
            $log = new Log();
            $log->old_value = Json::encode(Interest::find()->where(['interest_id' => $model->interest_id])->all(), $asArray = true) ;
            $interest->save();
            
            $log->new_value = Json::encode(Interest::find()->where(['interest_id' => $interest->interest_id])->all(), $asArray = true) ;
            $log->user_id = Yii::$app->user->identity->user_id;
            $log->type = 'Edited Interest';
            $log->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Interest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $interest = Interest::findOne($id);
        $interest->flag = 0;
        $interest->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Interest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Interest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Interest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
