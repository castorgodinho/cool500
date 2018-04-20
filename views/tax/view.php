<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tax */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tax-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tax_id',
            'name',
            'rate',
            'date',
        ],
    ]) ?>

</div>
