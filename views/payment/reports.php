<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchPayment */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="payment-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'invoice.invoice_code',
            'amount',
            'start_date',
            'mode',
            //'invoice_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
