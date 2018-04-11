<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AreaRate */

$this->title = $model->area_rate_id;
$this->params['breadcrumbs'][] = ['label' => 'Area Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-rate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->area_rate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->area_rate_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'area_rate_id',
            'rate',
            'start_date',
        ],
    ]) ?>

</div>
