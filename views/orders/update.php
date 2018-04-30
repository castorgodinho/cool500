<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-4 ">
    <h1><b>GIDC LOGO HERE</b></h1>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-8 text-right" style="margin-bottom:10px;">
    <h3> <b>Goa Industrial Development Corporation</b> </h3>
    <p>(A Goverment of Goa Undertaking)</p>
    <p>Plot No. 13-A-2, EDC Complex, Patto Plaza, Panjim-Goa 403001</p>
    <p>Tel: (91)(832)2437470 to 73 | Fax: (91)(832)2437478 to 79</p>
    <p>Email: goaidc1965@gmail.com | Website: http://www.goaidc.com</p>
    <p><b>GSTIN: </b>30AAATG7792FIZR | <b>PAN No. </b>AAATG77921</p>
  </div>
</div>
<hr>
<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-4">
    <p><b>To. </b> <?= $company->name ?></p>
    <p><b>Utility Plot No. </b></p>
    <p><?= $company->address ?></p>
    <p><?= $company->user->email ?> <?= $company->owner_phone ?></p>
    <p><b>GSTIN: </b><?= $company->gstin ?></p>

  </div>
  <div class="col-md-4 col-sm-4 col-xs-4">
    <p>Classification of Servises</p>
    <p>Rendting of Immovanle</p>
    <p>Property of Servises</p>
    <p>Clause 65(105) (ZZZZ)</p>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-4">
    <!-- <p><b>Tax Invoice No: </b></p> -->
    <p><b>Bill Date: <?= $billDate ?></b></p>
    <p><b>Due Date: <?= $invoiceDueDate ?></b></p>
    <p><b>Order Number: </b><?= $order->order_number ?></p>
  </div>
</div>
<h3 class="text-center"><b>Lease Rent Invoice</b></h3>
<div class="container ">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">

    <table class="table table-responsive">

      <tr>
        <td>  Previous Lease Period  </td>
        <td> <?= $prevPeriodFrom  ?> to <?= $prevPeriodTo ?></td>
      </tr>

      <tr>
        <td>Previous Lease Rent (INR) </td>
        <td><?= $previousLeaseRent ?></td>
      </tr>

      <tr>
        <?php if($previousLeaseRent != 0) { ?>
        <td>Previous SGST <?= round($previousSGSTAmount * 100 / $previousLeaseRent,1)   ?>% (INR) </td>
        <?php } else { ?>
        <td>Previous SGST (INR)</td>
        <?php } ?>
        <td><?= $previousCGSTAmount ?></td>
      </tr>

      <tr>
        <?php if($previousLeaseRent != 0) { ?>
        <td>Previous CGST <?= round($previousSGSTAmount * 100 / $previousLeaseRent,1)   ?>% (INR) </td>
        <?php } else { ?>
        <td>Previous CGST (INR)</td>
        <?php } ?>
        <td><?= $previousCGSTAmount ?></td>
      </tr>

      <tr>
        <td> Previous Total Tax  (INR) </td>
        <td><?= $previousTotalTax ?></td>
      </tr>

      <tr>
        <td> Penal Interest <?= $interest->rate ?>% (INR) </td>
        <td><?= $penalInterest ?></td>
      </tr>

      <tr>
        <td> Previous Remainaing Balance (INR) </td>
        <td><?= $prevNotPaid ?></td>
      </tr>

      <tr>
        <td>  Previous Due Total (A) (INR) </td>
        <td> <?= $previousDueTotal ?> </td>
      </tr>

      <tr>
        <td>  Current Lease Period  </td>
        <td> <?= $leasePeriodFrom  ?> to <?= $leasePeriodTo ?></td>
      </tr>

      <tr>
        <td>  Current Lease Rent (INR) </td>
        <td> <?= $currentLeaseRent ?> </td>
      </tr>

      <tr>
        <td>  Current CGST <?= $tax->rate/2 ?>% (INR)  </td>
        <td> <?= $currentCGSTAmount ?>  </td>
      </tr>

      <tr>
        <td>  Current SGST <?= $tax->rate/2 ?>% (INR)  </td>
        <td> <?= $currentSGSTAmount ?>  </td>
      </tr>

      <tr>
        <td>  Current Total Tax (INR) </td>
        <td> <?= $currentTotalTax ?>  </td>
      </tr>

      <tr>
        <td>  Current Due Total (B) (INR) </td>
        <td> <?= $currentDueTotal ?>  </td>
      </tr>

      <tr>
        <td>  Final Total ( C = A + B) </td>
        <td> <?= $currentDueTotal + $previousDueTotal ?>  </td>
      </tr>


    </table>
    </div>
  </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<?php
$time = strtotime($billDate);
$start_date = date('Y-m-d',$time);
?>

<tr>
  <td> <input value="<?= $order_id ?>" id="invoice-order_id" class="form-control" name="Invoice[order_id]" type="hidden"> </td>
  <td> <input value="<?= $rate->rate_id ?>" id="invoice-rate_id" class="form-control" name="Invoice[rate_id]" type="hidden"> </td>
  <td> <input value="<?= $tax->tax_id ?>" id="invoice-tax_id" class="form-control" name="Invoice[tax_id]" type="hidden"> </td>
  <td> <input value="<?= $start_date ?>" id="invoice-start_date" class="form-control" name="Invoice[start_date]" type="hidden"> </td>
  <td> <input value="<?= $interest->interest_id ?>" id="invoice-interest_id" class="form-control" name="Invoice[interest_id]" type="hidden"> </td>
  <td> <input value="<?= $currentDueTotal + $previousDueTotal ?>" id="invoice-total_amount" class="form-control" name="Invoice[total_amount]" type="hidden"> </td>
  <td><input value="<?= $currentDueTotal  ?>" id="invoice-current_total_dues" class="form-control" name="Invoice[current_total_dues]" aria-required="true" aria-invalid="true" type="hidden"></td>
  <td><input value="<?= 0 ?>" id="invoice-current_interest" class="form-control" name="Invoice[current_interest]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $currentTotalTax ?>" id="invoice-current_tax" class="form-control" name="Invoice[current_tax]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $currentLeaseRent ?>" id="invoice-current_lease_rent" class="form-control" name="Invoice[current_lease_rent]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $previousDueTotal ?>" id="invoice-prev_dues_total" class="form-control" name="Invoice[prev_dues_total]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $penalInterest ?>" id="invoice-prev_interest" class="form-control" name="Invoice[prev_interest]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $previousTotalTax ?>" id="invoice-prev_tax" class="form-control" name="Invoice[prev_tax]" aria-required="true" type="hidden"></td>
  <td><input value="<?= $currentDueTotal + $previousDueTotal ?>" id="invoice-grand_total" class="form-control" name="Invoice[grand_total]" type="hidden"></td>
  <td><input value="<?= $previousLeaseRent?>" id="invoice-prev_lease_rent" class="form-control" name="Invoice[prev_lease_rent]" type="hidden"></td>

</tr>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
</div>
  <?php ActiveForm::end(); ?>
