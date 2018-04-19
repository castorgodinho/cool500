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
    <td><?= $invoice->prev_lease_rent ?></td>
  </tr>

  <tr>
    <td>Previous SGST Amount</td>
    <td><?= $invoice->prev_tax/2 ?></td>
  </tr>

  <tr>
    <td>Previous CGST Amount</td>
    <td><?= $invoice->prev_tax/2 ?></td>
  </tr>

  <tr>
    <td> Previous Total Tax </td>
    <td><?= $invoice->prev_tax ?></td>
  </tr>

  <tr>
    <td> Penal Interest </td>
    <td><?= $invoice->prev_interest ?></td>
  </tr>

  <tr>
    <td>  Previous Due Total  </td>
    <td> <?= $invoice->prev_dues_total ?> </td>
  </tr>

  <tr>
    <td>  Current Lease Rent </td>
    <td> <?= $invoice->current_lease_rent  ?> </td>
  </tr>

  <tr>
    <td>  Current CGST Amount </td>
    <td> <?= $invoice->current_tax/2 ?>  </td>
  </tr>

  <tr>
    <td>  Current SGST Amount </td>
    <td> <?= $invoice->current_tax/2 ?>  </td>
  </tr>

  <tr>
    <td>  Current Total Tax </td>
    <td> <?= $invoice->current_tax ?>  </td>
  </tr>

  <tr>
    <td>  Current Due Total </td>
    <td> <?= $invoice->current_total_dues ?>  </td>
  </tr>

  <tr>
    <td>  Final Total ( C = A + B) </td>
    <td> <?= $invoice->grand_total?>  </td>
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
