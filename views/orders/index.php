<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchOrders */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company Units';
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'order_number',
            'company.name',
            /* 'plot_id', */
            /* 'built_area',*/
            /* 'shed_area', */
            // 'godown_area',
             'start_date',
             'end_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
