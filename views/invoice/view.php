<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<style>
  @page
    {
        size:  auto;   /* auto is the initial value */
        margin: 20px;  /* this affects the margin in the printer settings */
    }
    .bold-text{
      font-weight: bold;
    }
  @media print {
  body * {
    visibility: hidden;

  }
  #printableArea, #printableArea * {
    visibility: visible;
  }
  #printableArea {
    position: absolute;
    left: 0;
    top: 0;
  }

  body{
    border: 2px solid black;
  }


}


    body{

    }

.invoice-company-details p{
  line-height: 18px;
}
.cover p{
  line-height: 18px;
}
</style>

<input type="button" class="print-btn btn-success"  value="PRINT" /><br><br>

<div class="cover" id="printableArea" style=" padding: 10px;">
<div class="row">
  <div class="col-md-2 col-sm-2 col-xs-2 ">
    <h1><b>GIDC LOGO HERE</b></h1>
  </div>
  <div class="col-md-10 col-sm-10 col-xs-10 text-right" style="">
    <h3> <b>Goa Industrial Development Corporation</b> </h3>
    <p>(A Goverment of Goa Undertaking)</p>
    <p>Plot No. 13-A-2, EDC Complex, Patto Plaza, Panjim-Goa 403001</p>
    <p>Tel: (91)(832)2437470 to 73 | Fax: (91)(832)2437478 to 79</p>
    <p>Email: goaidc1965@gmail.com | Website: http://www.goaidc.com</p>
    <p><b>GSTIN: </b>30AAATG7792FIZR | <b>PAN No. </b>AAATG77921</p>
  </div>
</div>
<hr>
<div class="row invoice-company-details">
  <div class="col-md-4 col-sm-4 col-xs-4">
    <?php $company = $model->order->company;?>
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
    <p><b>Tax Invoice No: </b><?= $model->invoice_code ?></p>
    <p><b>Bill Date: </b> <?= $start_date  ?></p>
    <p><b>Due Date: </b><?= $invoiceDueDate ?></p>
    <p><b>Order Number: </b><?= $model->order->order_number ?></p>
  </div>
</div>
<h3 class="text-center"><b>Lease Rent Invoice</b></h3>
<div class="container ">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">


    <table class="table table-responsive">

      <tr>
        <td class='bold-text'>  Previous Lease Period  </td>
        <?php if($model->prev_lease_rent = 0 ) { ?>
        <td> <?= $prevPeriodFrom  ?> to <?= $prevPeriodTo ?></td>
        <?php } else {  ?>
        <td> - </td>
        <?php }   ?>
      </tr>

      <tr>
        <td class='bold-text'>Previous Lease Rent (INR)</td>
        <td><?= $model->prev_lease_rent ?></td>
      </tr>

      <tr>
        <?php if($model->prev_lease_rent != 0) { ?>
        <td class='bold-text'>Previous CGST <?= round($model->prev_tax/2 * 100/$model->prev_lease_rent,1) ?>% (INR)</td>
        <?php } else { ?>
        <td class='bold-text'>Previous CGST (INR)</td>
        <?php } ?>
        <td><?= $model->prev_tax/2 ?></td>
      </tr>

      <tr>
        <?php if($model->prev_lease_rent != 0) { ?>
        <td class='bold-text'>Previous SGST <?= round($model->prev_tax/2 * 100/$model->prev_lease_rent,1) ?>% (INR)</td>
        <?php } else { ?>
        <td class='bold-text'>Previous SGST (INR)</td>
        <?php } ?>
        <td><?= $model->prev_tax/2 ?></td>
      </tr>

      <tr>
        <td class='bold-text'> SAC Code </td>
        <td>9972</td>
      </tr>
      <tr>
        <td class='bold-text'> Previous Total Tax (INR)</td>
        <td><?= $model->prev_tax ?></td>
      </tr>

      <tr>
        <td class='bold-text'> Penal Interest <?= $model->interest->rate ?>% (INR) </td>
        <td><?= $model->prev_interest ?></td>
      </tr>

      <tr>
        <td class='bold-text'>  Previous Due Total (A) (INR) </td>
        <td> <?= $model->prev_dues_total ?> </td>
      </tr>

      <tr>
        <td class='bold-text'>  Current Lease Period  </td>
        <td> <?= $leasePeriodFrom  ?> to <?= $leasePeriodTo ?></td>
      </tr>

      <tr>
        <td class='bold-text'>  Current Lease Rent (INR) </td>
        <td> <?= $model->current_lease_rent  ?> </td>
      </tr>

      <tr>
        <td class='bold-text'>  Current CGST <?= $model->tax->rate/2 ?>% (INR) </td>
        <td> <?= $model->current_tax/2 ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>  Current SGST <?= $model->tax->rate/2 ?>% (INR) </td>
        <td> <?= $model->current_tax/2 ?>  </td>
      </tr>
      <tr>
        <td class='bold-text'> SAC Code </td>
        <td>9972</td>
      </tr>
      <tr>
        <td class='bold-text'>  Current Total Tax (INR) </td>
        <td> <?= $model->current_tax ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>  Current Due Total (B) (INR) </td>
        <td> <?= $model->current_total_dues ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>  Final Total ( C = A + B) (INR) </td>
        <td> <?= $model->grand_total?>  </td>
      </tr>


    </table>
    <hr>
    <p><b>Penal Interest @ <?= $model->interest->rate ?>% will apply on total dues adter due date</b></p>
    <p>This is a computer-generated document and it does not require a signature</p>
    <p><b>Disclaimer: </b>The data belongs to Goa IDC. For any communication related to the published data, Please contact at the above address</p>
    </div>
  </div>
</div>
</div>
<?php
  $script = <<< JS
    $(document).ready(function(){
      $('.print-btn').click(function(){
        window.print();
      });
    });
JS;
  $this->registerJS($script);
?>
