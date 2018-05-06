<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<div class='css'>

</div>
<!-- <style>
  @page
    {
        size:  auto;   
        margin: 20px;  /* this affects the margin in the printer settings */
    }
  table{
    font-size: 14px;
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
</style> -->
<input type="button" class="print-payment btn btn-success"  value="PRINT" /><br><br>
<input type="button" class="print-debit btn btn-success"  value="PRINT Debit NOTE" /><br><br>
<div class="cover" id="printableArea" style="border: 1px solid black; padding: 10px;">


<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-4 ">
    <h1><b>GIDC LOGO HERE</b></h1>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-8 text-right" style="margin-bottom:10px;">
    <h3> <b>Goa Industrial Development Corporation</b> </h3>
    <p>(A Goverment of Goa Undertaking)</p>
    <p>Plot No. 13-A-2, EDC Complex, Patto Plaza, Panjim-Goa 403001</p>
    <!-- <p>Tel: (91)(832)2437470 to 73 | Fax: (91)(832)2437478 to 79</p>
    <p>Email: goaidc1965@gmail.com | Website: http://www.goaidc.com</p> -->
    <p><b>GSTIN: </b>30AAATG7792FIZR <!-- | <b>PAN No. </b>AAATG77921 --></p>
  </div>
</div>
<hr>
    <center> <h3>LEASE PAYMENT RECEIPT</h3> </center>
    <table class="table">

     <tr>
       <td>Unit ID</td>
       <td><?= $model->invoice->order->order_number ?></td>
     </tr>
     <tr>

       <td>Tax Invoice No</td>
       <td><?= $model->invoice->invoice_code ?></td>
     </tr>
     <tr>
       <td>Customer Name</td>
       <td><?= $model->invoice->order->company->name ?></td>
     </tr>
     <tr>
       <td>GSTIN</td>
       <td><?= $model->invoice->order->company->gstin ?></td>
     </tr>
     <tr>
       <td>Plot No</td>
       <td><?= $model->invoice->order->plots ?></td>
     </tr>
     <tr>
       <td>Industrial Area</td>
       <td><?= $model->invoice->order->area->name ?></td>
     </tr>
     <tr>
       <td>Previous Lease Rent Dues as on</td>
       <td><?= $model->invoice->prev_lease_rent ?></td>
     </tr>
     <?php
      $previousLeaseRent = $model->invoice->prev_lease_rent;
      $previousSGSTAmount = $model->invoice->prev_interest/2;
     ?>
     <tr>
       <?php if($model->invoice->prev_lease_rent!= 0) { ?>
       <td>Previous CGST <?= round(($model->invoice->prev_tax/2) * 100 / $model->invoice->prev_lease_rent,1)   ?>% (INR) </td>
       <?php } else { ?>
       <td>Previous CGST (INR)</td>
       <?php } ?>
       <td><?= $model->invoice->prev_tax/2 ?></td>
     </tr>

     <tr>

        <?php if($model->invoice->prev_lease_rent != 0) { ?>
        <td>Previous SGST <?= round(($model->invoice->prev_tax/2) * 100 / $model->invoice->prev_lease_rent,1)   ?>% (INR) </td>
        <?php } else { ?>
        <td>Previous SGST (INR)</td>
        <?php } ?>
        <td><?= $model->invoice->prev_tax/2 ?></td>
    </tr>
     <tr>
       <td>Penal Interest <?= $model->invoice->interest->rate ?>% (INR)</td>
       <td><?= $model->invoice->prev_interest ?></td>

     </tr>
     <tr>
       <!-- <td>Company</td>
       <td><?= $model->invoice->order->company->name ?></td>
     </tr> -->
     <!-- <tr>
       <td>Amount  (INR) </td>
       <td><?= $amount = round($model->amount * 100 / ($model->invoice->tax->rate+100)) ?></td>

     </tr> -->
    <?php if($model->penal != 0) {?>
     <tr>

       <td>Lease Rent</td>
       <td><?= $model->invoice->current_lease_rent ?></td>
     </tr>
     <tr>
        <td>  Current CGST <?= ($model->invoice->tax->rate)/2 ?>% (INR)  </td>
        <td> <?= $model->invoice->current_tax / 2 ?>  </td>
      </tr>

      <tr>
        <td>  Current SGST <?= ($model->invoice->tax->rate)/2 ?>% (INR)  </td>
        <td> <?= $model->invoice->current_tax / 2 ?>  </td>
      </tr>
     <tr>
       <td>Penal Interest</td>
       <td><?= $model->invoice->current_interest ?></td>

       <!-- <td>Penal Interest  (INR) </td>
       <td><?= $model->penal ?></td> -->

     </tr>
         <?php } ?>
     <tr>
       <td>CGST <?= $model->invoice->tax->rate /2  ?> % (INR)</td>
       <td><?= ($amount * ($model->invoice->tax->rate/100) / 2 )  ?></td>
     </tr>
     <tr>
       <td>SGST <?= $model->invoice->tax->rate /2  ?> % (INR)</td>
       <td><?= ($amount * ($model->invoice->tax->rate/100) / 2)?></td>
     </tr>
     <tr>
       <td>Total GST <?= $model->invoice->tax->rate   ?> % (INR)</td>
       <td><?= round($amount * ($model->invoice->tax->rate/100) )?></td>

     </tr>
     <!-- <tr>
       <td>Total GST <?= $model->invoice->tax->rate   ?> % (INR)</td>
       <td><?= round(($model->invoice->current_tax) )?></td>

     </tr> -->
     <!-- <tr>
       <td>TDS (INR)</td>
       <td><?= round( ($model->tds_amount )) ?></td>
     </tr> -->
     <tr>

       <td> Total Bill Amount </td>
       <td><?= round($model->balance_amount + $model->amount) ?></td>
     </tr>

     <tr>
       <td> Amount Paid </td>
       <td><?= round($model->amount) ?></td>
     </tr>

     <tr>
       <td> Balance Amount </td>
       <td><?= round($model->balance_amount) ?></td>
     </tr>

     <!-- <tr>
       <td>Balance Amount (INR) </td>
       <td><?= $amount = round($model->amount * 100 / ($model->invoice->tax->rate+100)) ?></td>
     </tr> -->
     <?php if($model->cheque_no) {?>
       <tr>
         <td>Cheque  No</td>
         <td><?= $model->cheque_no ?></td>
       </tr>
    <?php } ?>
    <?php if($model->cheque_no){ ?>

     <tr>
       <td>Transaction No </td>
       <td><?= $model->cheque_no ?></td>
     </tr>
    <?php } ?>
    <tr>
      <td>Payment Mode</td>
      <td><?= $model->mode ?></td>
    </tr>
     <tr>
       <td>Date of Receipt</td>
       <td><?= $model->start_date?></td>
     </tr>

    </table>
    <p><b>NOTE: </b>Receipt is valid subject to realization of your cheque. <br>
This is a computer-generated document and it does not require a signature. <br>
<b>Disclaimer: </b>The data belongs to Goa GIDC. For any communication related to the published data, please contact at the above address </p>
</div>

</div>

<div class="container cover" id="print-debit">
  <h2 class="text-center">Debit Note</h2>
  <div class="row">
    <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
      <p><b>Debit Note Number: </b><?= $debit->debit_id ?></p>
      <p><b>Invoice Number: </b><?= $invoice->invoice_code ?></p>
      <p><b>Date: </b><?= $model->start_date ?></p>
    </div>
    <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6 text-right">
      <p><b>Company Name: </b><?= $invoice->order->company->name ?></p>
      <p><b>GSTIN: </b><?= $invoice->order->company->gstin  ?></p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
      <table class="table table-bordered">
        <tr>
          <td>Particulars</td>
          <td>Amount</td>
        </tr>
        <tr>
          <td>Penal Interest of Rs. <?= $debit->penal ?></td>
          <td> <?= $debit->penal ?></td>
        </tr>
      </table>
    </div>
  </div>
</div>


<?php

  $script = <<< JS
    var cssPayment = " <style>@page {size:  auto;   margin: 20px;}  table{ font-size: 14px; }  @media print {  body * { visibility: hidden; }  #printableArea, #printableArea * { visibility: visible; }  #printableArea { position: absolute; left: 0; top: 0;} body{ border: 2px solid black; } }</style>";
    var cssDebit = " <style>@page {size:  auto;   margin: 20px;}  table{ font-size: 14px; }  @media print {  body * { visibility: hidden; }  #print-debit, #print-debit * { visibility: visible; }  #print-debit { position: absolute; left: 0; top: 0;} }</style>";
    $(document).ready(function(){
      $('.print-payment').click(function(){
        $('.css').empty().append(cssPayment);
        window.print();
      });
      $('.print-debit').click(function(){
        $('.css').empty().append(cssDebit);
        window.print();
      });
    });
JS;
$this->registerJS($script);
?>
