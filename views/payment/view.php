<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


?>
<style>
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
}
</style>
<input type="button" class="print-btn btn-success"  value="PRINT" /><br><br>
<div class="cover" id="printableArea" style="border: 1px solid black; padding: 10px;">


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
    <center> <h2>RECEIPT</h2> </center>
    <table class="table">
     <th></th>
     <th></th>
     <tr>
       <td>Company</td>
       <td><?= $model->invoice->order->company->name ?></td>
     </tr>
     <tr>
       <td>Amount (INR) </td>
       <td><?= $amount = round($model->amount * 100 / ($model->invoice->tax->rate+100)) ?></td>
     </tr>
     <tr>
       <td>GST (INR)</td>
       <td><?= round($amount * ($model->invoice->tax->rate/100)) ?></td>
     </tr>
     <tr>
       <td>TDS (INR)</td>
       <td><?= round( ($model->tds_amount )) ?></td>
     </tr>

     <tr>
       <td>Total Amount </td>
       <td><?= round($model->amount + $model->tds_amount) ?></td>
     </tr>
     <tr>
       <td>DATE</td>
       <td><?= $model->start_date?></td>
     </tr>
     <tr>
       <td>Payment Mode</td>
       <td><?= $model->mode ?></td>
     </tr>
     <tr>
       <td>Invoice ID</td>
       <td><?= $model->invoice->invoice_code ?></td>
     </tr>
    </table>
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