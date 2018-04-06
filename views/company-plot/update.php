<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyPlot */

$this->title = 'Update Company Plot: ' . $model->company_id;
$this->params['breadcrumbs'][] = ['label' => 'Company Plots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_id, 'url' => ['view', 'company_id' => $model->company_id, 'plot_id' => $model->plot_id, 'start_date' => $model->start_date]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-plot-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
