<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Payment;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchInvoice */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="invoice-index">

   
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'from_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ])  ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'to_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ])  ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'invoice_code',
            'start_date',
            'order.order_number',
            'order.company.name',
            'grand_total',
            [
                'label' => 'Amount Paid',
                'value' => function ($dataProvider) {
                    $amount = Payment::find()->where(['invoice_id' => $dataProvider->invoice_id])->sum('amount');
                    
                    if($amount == '')
                     return 0;
                    else
                        return $amount;
                },
            ],
            //'start_date',
            //'total_amount',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
