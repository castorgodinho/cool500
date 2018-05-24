<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPayment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Receipt';
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Receipt', ['search'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Tax Invoice Number',
                'attribute' => 'invoice_id',
                'value' => 'invoice.invoice_code',
            ],
            'amount',
            [
                'label' => 'Receipt Date',
                'attribute' => 'start_date',
                'value' => function($dataProvider){
                    return date('d-m-Y', strtotime($dataProvider->start_date));
                }
            ],
            'mode',
            'invoice.order.company.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
