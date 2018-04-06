<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Plot */

$this->title = 'Update Plot: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->plot_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plot-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
