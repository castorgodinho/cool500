<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAreaRate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Area Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Area Rate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'area_rate_id',
            'rate',
            'start_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
