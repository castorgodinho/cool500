<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['action' => 'index.php?r=payment/create']); ?>

<table class="table">
  <th></th>
  <th></th>
  <tr>
    <td>Previous Lease Rent</td>
    <td><?= $previousLeaseRent ?></td>
  </tr>

  <tr>
    <td>Previous SGST Amount</td>
    <td><?= $previousSGSTAmount ?></td>
  </tr>

  <tr>
    <td>Previous CGST Amount</td>
    <td><?= $previousCGSTAmount ?></td>
  </tr>

  <tr>
    <td> Previous Total Tax </td>
    <td><?= $previousTotalTax ?></td>
  </tr>

  <tr>
    <td> Penal Interest </td>
    <td><?= $penalInterest ?></td>
  </tr>

  <tr>
    <td>  Previous Due Total  </td>
    <td> <?= $previousDueTotal ?> </td>
  </tr>

  <tr>
    <td>  Current Lease Rent </td>
    <td> <?= $currentLeaseRent ?> </td>
  </tr>

  <tr>
    <td>  Current CGST Amount </td>
    <td> <?= $currentCGSTAmount ?>  </td>
  </tr>

  <tr>
    <td>  Current SGST Amount </td>
    <td> <?= $currentSGSTAmount ?>  </td>
  </tr>

  <tr>
    <td>  Current Total Tax </td>
    <td> <?= $currentTotalTax ?>  </td>
  </tr>

  <tr>
    <td>  Current Due Total </td>
    <td> <?= $currentDueTotal ?>  </td>
  </tr>

  <tr>
    <td>  Final Total ( C = A + B) </td>
    <td> <?= $currentDueTotal + $previousDueTotal ?>  </td>
  </tr>

  <tr>
    <td>  <h2>BALANCE</h2> </td>
    <td> <h3><?= $balanceAmount ?></h3>  </td>
  </tr>


</table>

<?= $form->field($model, 'invoice_id')->textInput() ?>

<?= $form->field($model, 'amount')->textInput() ?>

<?= $form->field($model, 'start_date')->textInput() ?>

<?= $form->field($model, 'order_id')->textInput() ?>

<?= $form->field($model, 'mode')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
