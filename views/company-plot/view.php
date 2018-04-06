<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyPlot */

$this->title = $model->company_id;
$this->params['breadcrumbs'][] = ['label' => 'Company Plots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-plot-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'company_id' => $model->company_id, 'plot_id' => $model->plot_id, 'start_date' => $model->start_date], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'company_id' => $model->company_id, 'plot_id' => $model->plot_id, 'start_date' => $model->start_date], [
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
            'company_id',
            'plot_id',
            'start_date',
        ],
    ]) ?>

</div>
