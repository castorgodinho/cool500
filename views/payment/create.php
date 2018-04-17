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
<?php if($balanceAmount != -1) { ?>
<input id="payment-invoice_id" class="form-control" name="Payment[invoice_id]" value="<?= $model->invoice_id ?>" aria-invalid="false" type="hidden">

<?= $form->field($model, 'amount')->textInput() ?>

<input id="payment-start_date" class="form-control" name="Payment[start_date]" value="<?= $model->start_date?>" type="hidden">

<input id="payment-order_id" class="form-control" name="Payment[order_id]" value="<?= $model->order_id?>" type="hidden">

<?= $form->field($model, 'mode')->dropDownList([ 'cash' => 'CASH', 'cheque' => 'CHEQUE','card' => 'CARD' ], ['prompt' => '']) ?>

<div class="form-group">
    <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php  } ?>
