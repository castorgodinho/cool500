<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AreaRate */

$this->title = 'Update Area Rate: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Area Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->area_rate_id, 'url' => ['view', 'id' => $model->area_rate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="area-rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
