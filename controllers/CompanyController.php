<?php

namespace app\controllers;

use Yii;
use app\models\Company;
use app\models\Users;
use app\models\Orders;
use app\models\Log;
use yii\helpers\Json;
use app\models\SearchCompany;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
            /* 'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createCompany'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['viewCompany'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['updateCompnay'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['deleteCompany'],
                    ],
                ],
            ], */
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexCompany')){
            $searchModel = new SearchCompany();
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
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->user->can('ViewCompany', ['company' => $model])){
            $model = $this->findModel($id);
            $orders = Orders::find()->where(['company_id' => $model->company_id])->all();

            return $this->render('view', [
                'model' => $model,
                'orders' => $orders
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createCompany')){
            $model = new Company();
            $user = new Users();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($user);
            }
            if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
                $user->type = 'company';
                $user->save(false);
                /* Assigning company role */
                $auth = \Yii::$app->authManager;
                $companyRole = $auth->getRole('company');
                $auth->assign($companyRole, $user->user_id);
                $model->user_id = $user->user_id;
                $model->save();

                return $this->redirect(['view', 'id' => $model->company_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateCompany')){
            $model = $this->findModel($id);
            $user = Users::findOne($model->user_id);
            $user->password = "";
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            if (Yii::$app->request->isAjax && $user->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($user);
            }
            if ($model->load(Yii::$app->request->post())) {
                if($user->password != ''){
                    $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
                }else{
                    $user->password = Users::findOne($user->user_id);
                }
                $log = new Log();
                $log->old_value = Json::encode(Company::find()->joinWith('user')->where(['company_id' => $model->company_id])->all(), $asArray = true) ;
                $model->save();
                $user->save();
                $log->new_value = Json::encode(Company::find()->joinWith('user')->where(['company_id' => $model->company_id])->all(), $asArray = true) ;
                $log->user_id = Yii::$app->user->identity->user_id;
                $log->type = 'Company';
                $log->save();
                return $this->redirect(['view', 'id' => $model->company_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteCompany')){
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
