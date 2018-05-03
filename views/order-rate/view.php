<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRate */

$this->title = $model->order_rate_id;
$this->params['breadcrumbs'][] = ['label' => 'Order Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-rate-view">





    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'start_date',
            'end_date',
            'amount1',
            'amount2',
            'order.order_number',
        ],
    ]) ?>

</div>
