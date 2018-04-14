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
    <p><b>Tax Invoice No: </b></p>
    <p><b>Bill Date: </b></p>
    <p><b>Due Date: </b></p>
    <p><b>Order Number: </b><?= $order->order_number ?></p>
  </div>
</div>
<h3 class="text-center"><b>Lease Rent Invoice</b></h3>
<div class="container ">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">

    <table class="tables">
      <tr>
        <td>Name</td>
        <td>Name</td>
      </tr>
    </table>
    <table class="table table-responsive">
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
    
    
    </table>
    </div>
  </div>
</div>

<?php $form = ActiveForm::begin(); ?>

<tr>
  <td> <input value="<?= $order_id ?>" id="invoice-order_id" class="form-control" name="Invoice[order_id]" type="text"> </td>
  <td> <input value="<?= $rate->rate_id ?>" id="invoice-rate_id" class="form-control" name="Invoice[rate_id]" type="text"> </td>
  <td> <input value="<?= $tax->tax_id ?>" id="invoice-tax_id" class="form-control" name="Invoice[tax_id]" type="text"> </td>
  <td> <input value="<?= $start_date ?>" id="invoice-start_date" class="form-control" name="Invoice[start_date]" type="text"> </td>
  <td> <input value="<?= $interest->interest_id ?>" id="invoice-interest_id" class="form-control" name="Invoice[interest_id]" type="text"> </td>
  <td> <input value="<?= $currentDueTotal + $previousDueTotal ?>" id="invoice-total_amount" class="form-control" name="Invoice[total_amount]" type="text"> </td>
</tr>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
  <?php ActiveForm::end(); ?>