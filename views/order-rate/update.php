<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderRate */

$this->title = 'Update Order Rate: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Order Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_rate_id, 'url' => ['view', 'id' => $model->order_rate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-rate-update">

    <h1><?= Html::encode("Update Rate") ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
