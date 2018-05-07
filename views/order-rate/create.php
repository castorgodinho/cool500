<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrderRate */

$this->title = 'Create Order Rate';
$this->params['breadcrumbs'][] = ['label' => 'Order Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
