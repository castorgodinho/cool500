<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'invoice_id')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
