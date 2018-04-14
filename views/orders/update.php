<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


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
  <?php $form = ActiveForm::begin(); ?>

  <tr>
    <td> <input value="<?= $order_id ?>" id="invoice-order_id" class="form-control" name="Invoice[order_id]" type="text"> </td>
    <td> <input value="<?= $rate->rate_id ?>" id="invoice-rate_id" class="form-control" name="Invoice[rate_id]" type="text"> </td>
    <td> <input value="<?= $tax->tax_id ?>" id="invoice-tax_id" class="form-control" name="Invoice[tax_id]" type="text"> </td>
    <td> <input value="<?= $start_date ?>" id="invoice-start_date" class="form-control" name="Invoice[start_date]" type="text"> </td>
    <td> <input value="<?= $interest->interest_id ?>" id="invoice-interest_id" class="form-control" name="Invoice[interest_id]" type="text"> </td>
    <td> <input value="<?= $currentDueTotal + $previousDueTotal ?>" id="invoice-total_amount" class="form-control" name="Invoice[total_amount]" type="text"> </td>
  </tr>

</table>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
  <?php ActiveForm::end(); ?>
