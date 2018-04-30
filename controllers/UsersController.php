<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\SearchUsers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Log;
use yii\helpers\Json;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('indexUsers')){
            $searchModel = new SearchUsers();
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
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('viewUsers')){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }


    public function actionChangePassword()
    {

        if (\Yii::$app->user->can('changePassword')){
            $model = Users::findOne(Yii::$app->user->identity->user_id);
            $model->password = "";
            $model->scenario = 'update-password';
            if ($model->load(Yii::$app->request->post())) {
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->save();
                if (\Yii::$app->user->can('staff')){
                    return $this->redirect(['company/create']);
                    /* Have to change redirect */
                }else if (\Yii::$app->user->can('accounts')){
                    return $this->redirect(['orders/create']);
                }else if (\Yii::$app->user->can('company')){
                    return $this->redirect(['company/view', 'id' => Company::find()->where(['user_id' => Yii::$app->user->identity->user_id])->one()->company_id]);
                }
            }else{
                return $this->render('change-password', [
                    'model' => $model,
                ]);
            }

        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (\Yii::$app->user->can('createUsers')){
            $model = new Users();
            $model->scenario = 'create';
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $model->save();
                /* Assigning company role */
                $auth = \Yii::$app->authManager;
                $role = $auth->getRole($model->type);
                $auth->assign($role, $model->user_id);
                return $this->redirect(['view', 'id' => $model->user_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->can('updateUsers')){
            $model = $this->findModel($id);
            $model->password = "";
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                if($model->password != ""){
                    $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                }else{
                    $model->password = Users::findOne($model->user_id)->password;
                }
                $auth = Yii::$app->authManager;
                $auth->revokeAll($model->user_id);
                $role = $auth->getRole($model->type);
                $auth->assign($role, $model->user_id);
                $log = new Log();
                $log->old_value = Json::encode(Users::find()->where(['user_id' => $model->user_id])->all(), $asArray = true) ;
                $model->save();
                $log->new_value = Json::encode(Users::find()->where(['user_id' => $model->user_id])->all(), $asArray = true) ;
                $log->user_id = Yii::$app->user->identity->user_id;
                $log->type = 'Edited Users';
                $log->save();

                return $this->redirect(['view', 'id' => $model->user_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('deleteUsers')){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            throw new \yii\web\ForbiddenHttpException;
        }
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
