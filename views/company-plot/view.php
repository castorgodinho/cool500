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


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'company_id',
            'plot_id',
            'start_date',
        ],
    ]) ?>

</div>
