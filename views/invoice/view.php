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
<div class="row">
  <div class="col-md-2 text-right">
    <p><input type="button" class="print-btn btn btn-success"  value="Print" /> <?= "<a class='btn btn-success' href='index.php?r=invoice/mail&id=".$model->invoice_id."' />Send Email</a>"; ?></p>
  </div>
  <div class="col-md-2 text-right">

  </div>



  <div class="col-md-2 text-left">

    <?php $payments = $model->payments;
      $flag = 0;
      foreach($payments as $payment){
        if($payment->tds_file && $flag == 0){
          echo "<a class='btn btn-success' href='".$payment->tds_file."' />Download TDS file</a>";
          $flag = 1;
        }

      }
    ?>
  </div>
</div>
<br><br>
<div class="cover" id="printableArea" style=" padding: 10px;">
<div class="row">
  <div class="col-md-3 col-sm-3 col-xs-3 ">
    <img src="img/logo.jpg" class="img img-responsive" alt="" srcset="">
  </div>
  <div class="col-md-9 col-sm-9 col-xs-9 text-right" style="">
    <h4> <b>Goa Industrial Development Corporation</b> </h4>
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
    <p><b>To </b> <?= $company->name ?></p>
<!--     <p><b>Utility Plot No. </b></p> -->
    <p><?= $model->order->area->name ?></p>
    <p><?= $company->user->email ?> <?= $company->owner_phone ?></p>
    <p><b>GSTIN: </b><?= $company->gstin ?></p>

  </div>
  <div class="col-md-4 col-sm-4 col-xs-4">
    <p>Classification of Servises</p>
    <p>Renting of Immovanle</p>
    <p>Property of Servises</p>
    <p>Clause 65(105) (ZZZZ)</p>
  </div>
  <div class="col-md-4 col-sm-4 col-xs-4">
    <p><b>Tax Invoice No: </b><?= $model->invoice_code ?></p>
    <p><b>Bill Date: </b> <?= $start_date  ?></p>
    <p><b>Due Date: </b><?= $invoiceDueDate ?></p>
    <p><b>User ID: </b><?= $model->order->order_number ?></p>
  </div>
</div>
<h3 class="text-center"><b>Lease Rent Invoice</b></h3>
<div class="container ">
  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">


    <table class="table table-responsive">
      <tr>
        <td colspan='2'><b>1. Previous Dues Description: (B)</b></td>
      </tr>
      <tr>
        <td class='bold-text'>  Previous Lease Period:  </td>
        <?php if($model->prev_lease_rent != 0 ) { ?>
        <td> <?= $prevPeriodFrom  ?> to <?= $prevPeriodTo ?></td>
        <?php } else {  ?>
        <td> - </td>
        <?php } ?>
      </tr>

      <tr>
        <td class='bold-text'>Previous Lease Rent (INR): SAC Code: 9972</td>
        <td><?= $model->prev_lease_rent ?></td>
      </tr>

      <tr>
        <?php if($model->prev_lease_rent != 0) { ?>
        <td class='bold-text'>CGST <?= round($model->prev_tax/2 * 100/$model->prev_lease_rent,1) ?>% (INR):</td>
        <?php } else { ?>
        <td class='bold-text'>CGST (INR):</td>
        <?php } ?>
        <td><?= $model->prev_tax/2 ?></td>
      </tr>

      <tr>
        <?php if($model->prev_lease_rent != 0) { ?>
        <td class='bold-text'>SGST <?= round($model->prev_tax/2 * 100/$model->prev_lease_rent,1) ?>% (INR):</td>
        <?php } else { ?>
        <td class='bold-text'>SGST (INR):</td>
        <?php } ?>
        <td><?= $model->prev_tax/2 ?></td>
      </tr>

      <!-- <tr>
        <td class='bold-text'> SAC Code </td>
        <td>9972</td>
      </tr> -->
      <tr>
        <td class='bold-text'>Total Tax (INR):</td>
        <td><?= $model->prev_tax ?></td>
      </tr>

      <tr>
        <td class='bold-text'> Penal Interest <!-- <?= $model->interest->rate ?>%  -->(INR): </td>
        <td><?= $model->prev_interest ?></td>
      </tr>
      <tr>
        <td class='bold-text'>  Previous Due Description (A) (INR): </td>
        <td> <?= $model->prev_dues_total ?> </td>
      </tr>
      <tr>
        <td colspan='2'><b>2. Current Dues Description (B):</b></td>
      </tr>
      <tr>
        <td class='bold-text'>Lease Period:  </td>
        <td> <?= $leasePeriodFrom  ?> to <?= $leasePeriodTo ?></td>
      </tr>

      <tr>
        <td class='bold-text'>Lease Rent (INR): SAC Code: 9972: </td>
        <td> <?= $model->current_lease_rent  ?> </td>
      </tr>

      <tr>
        <td class='bold-text'>CGST <?= $model->tax->rate/2 ?>% (INR): </td>
        <td> <?= $model->current_tax/2 ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>SGST <?= $model->tax->rate/2 ?>% (INR): </td>
        <td> <?= $model->current_tax/2 ?>  </td>
      </tr>
      <!-- <tr>
        <td class='bold-text'> SAC Code </td>
        <td>9972</td>
      </tr> -->
      <tr>
        <td class='bold-text'>Total Tax (INR): </td>
        <td> <?= $model->current_tax ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>  Current Due Description (B) (INR): </td>
        <td> <?= $model->current_dues_total ?>  </td>
      </tr>

      <tr>
        <td class='bold-text'>  Total Dues ( C = A + B) (INR): </td>
        <td> <?= $model->total_amount?>  </td>
      </tr>
      <tr>
        <td class='bold-text'>  Due Date: </td>
        <td> <?= $invoiceDueDate ?> </td>
      </tr>


    </table>
    <hr>
    <div class="row">
          <div class="col-md-8 col-sm-8 col-xs-8">
            <p><b>Penal Interest @ <?= $model->interest->rate ?>% will apply on total dues after due date</b></p>
            <p><b>Disclaimer: </b>The data belongs to Goa IDC. For any communication related to the published data, Please contact at the above address</p>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4 text-center">
            <p>Authorised</p>
            <p>Signature</p>
          </div>
    </div>
    </div>
  </div>
</div>
</div>
<br>
<?php if(Yii::$app->user->can('admin') || Yii::$app->user->can('company')){
  echo "<center><a href='index.php?r=payment/render-payment&id=". $model->invoice_code  ."' class='btn btn-primary text-center'>Pay Online</a></center>";
} ?>
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
