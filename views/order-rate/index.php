<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchOrderRate */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'start_date',
            'end_date',
            'amount1',
            'amount2',
            [
                'attribute' => 'flag',
                'value' => function($dataProvider){
                    if($dataProvider->flag == '1'){
                        return 'Current';
                    }else{
                        return 'Old';
                    }
                }
            ],
            [
                'attribute' => 'order_id',
                'value' => 'order.order_number',

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
