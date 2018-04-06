<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Plot */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plot-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->plot_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->plot_id], [
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
            'plot_id',
            'area_id',
            'name',
            'area_of_plot',
        ],
    ]) ?>

</div>
