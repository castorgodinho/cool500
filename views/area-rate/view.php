<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AreaRate */

$this->title = $model->area_id;
$this->params['breadcrumbs'][] = ['label' => 'Area Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-rate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'area_id' => $model->area_id, 'rate_id' => $model->rate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'area_id' => $model->area_id, 'rate_id' => $model->rate_id], [
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
            'area_id',
            'rate_id',
        ],
    ]) ?>

</div>
