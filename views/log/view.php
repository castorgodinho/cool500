<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Log */

$this->title = $model->log_id;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'log_id',
            'type',
            'create_date',
            'updated_date',
            'user.email',
        ],
    ]) ?>
    <h2>Old Values</h2>
    <?php 
    
        $dataProvider = new yii\data\ArrayDataProvider([
                'allModels' => json_decode($model->old_value),
                'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>
    <h2>New Values</h2>
    <?php 
    
        $dataProvider = new yii\data\ArrayDataProvider([
                'allModels' => json_decode($model->new_value),
                'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    ]); ?>
</div>
