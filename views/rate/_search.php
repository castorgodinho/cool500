<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchRate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rate_id') ?>

    <?= $form->field($model, 'area_id') ?>

    <?= $form->field($model, 'extra') ?>

    <?= $form->field($model, 'rate') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
