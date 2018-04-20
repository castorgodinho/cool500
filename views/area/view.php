<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\AreaRate;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Area */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'area_id',
            'name',
            'total_area',
        ],
    ]) ?>


    <?php 
        $query = AreaRate::find()->where(['area_id' => $id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'start_date',
            'area_rate',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
