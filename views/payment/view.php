<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->payment_id;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
?>
<div class="payment-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->payment_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->payment_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table">
     <th></th>
     <th></th>
     <tr>
       <td>Payment ID</td>
       <td><?= $model->payment_id ?></td>
     </tr>
     <tr>
       <td>Company</td>
       <td><?= $model->invoice->order->company->name ?></td>
     </tr>
     <tr>
       <td>Amount</td>
       <td><?= $model->amount ?></td>
     </tr>
     <tr>
       <td>DATE</td>
       <td><?= $model->start_date?></td>
     </tr>
     <tr>
       <td>Payment Mode</td>
       <td><?= $model->mode ?></td>
     </tr>
     <tr>
       <td>Invoice ID</td>
       <td><?= $model->invoice->invoice_code ?></td>
     </tr>
    </table>


</div>
