<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchInvoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoices';
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'invoice_code',
            'tax.rate',
            'interest.rate',
            'order.order_number',
            [

                'attribute' =>'order_id',
                'label' => 'Company',
                'value' =>  'order.company.name',
            ],

            [
                'label' => 'Email',
                'value' => function($dataProvider){
                    if($dataProvider->email_status == 1){
                        return "Sent";
                    }else{
                        return "Not Sent";
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
