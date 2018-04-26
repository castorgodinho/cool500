<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchPlot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plot-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'plot_id') ?>

    <?= $form->field($model, 'area_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'area_of_plot') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
