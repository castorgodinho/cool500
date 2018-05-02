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
    <?php if($invoice->prev_lease_rent != 0) { ?>
    <td>Previous SGST <?= round($invoice->prev_tax/2 * 100/$invoice->prev_lease_rent,1) ?>% (INR)</td>
    <?php } else { ?>
    <td>Previous SGST (INR)</td>
    <?php } ?>
    <td><?= $invoice->prev_tax ?></td>
  </tr>

  <tr>
    <?php if($invoice->prev_lease_rent != 0) { ?>
    <td>Previous CGST <?= round($invoice->prev_tax/2 * 100/$invoice->prev_lease_rent,1) ?>% (INR)</td>
    <?php } else { ?>
    <td>Previous CGST (INR)</td>
    <?php } ?>
    <td><?= $invoice->prev_tax/2 ?></td>
  </tr>

  <tr>
    <td> Previous Total Tax </td>
    <td><?= $invoice->prev_tax ?></td>
  </tr>

  <tr>
    <td> Penal  Interest  <?= $invoice->interest->rate ?>% (INR) </td>
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
    <td>  Current CGST <?= $invoice->tax->rate/2 ?>% (INR) Amount </td>
    <td> <?= $invoice->current_tax/2 ?>  </td>
  </tr>

  <tr>
    <td>  Current SGST <?= $invoice->tax->rate/2 ?>% (INR) Amount </td>
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
<?php if($balanceAmount != 0) { ?>
<input id="payment-invoice_id" class="form-control" name="Payment[invoice_id]" value="<?= $model->invoice_id ?>" aria-invalid="false" type="hidden">

<?= $form->field($model, 'amount')->textInput() ?>

<input id="payment-start_date" class="form-control" name="Payment[start_date]" value="<?= $model->start_date?>" type="hidden">

<input id="payment-order_id" class="form-control" name="Payment[order_id]" value="<?= $model->order_id?>" type="hidden">

<input id="payment-penal" class="form-control" name="Payment[penal]" value="<?= $PenalInterestAmount?>" type="hidden">

<input id="payment-lease_rent" class="form-control" name="Payment[lease_rent]" value="<?= $lease_rent?>" type="hidden">

<input id="payment-total_tax" class="form-control" name="Payment[total_tax]" value="<?= $total_tax ?>" type="hidden">

<input id="payment-balance_amount" class="form-control" name="Payment[balance_amount]" value="<?= $balanceAmount ?>" type="hidden ">

<?= $form->field($model, 'mode')->dropDownList([ 'cash' => 'CASH', 'cheque' => 'CHEQUE','card' => 'CARD' ], ['prompt' => '', 'class' => 'mode form-control']) ?>
<div class="cheque-div">

</div>
<?php if($tds_amount == 0 ) { ?>

  <label for="">TDS</label>
  <select id='tds_triger' class="form-control" name="tds">
    <option value="tds">NO TDS</option>
    <option value="no-tds">TDS</option>
  </select>


  <div class="hide-div">
    <br>
  <label for="">TDS RATE</label>
    <input id="payment-tds_rate" class="form-control" name="Payment[tds_rate]" value="0" type="text">
  </div>
  <?php
  $script = <<< JS
    $(document).ready(function(){
      var cheque_no ="<br><div class=\"form-group field-payment-cheque_no\">"+
"<label class=\"control-label\" for=\"payment-cheque_no\">Cheque No</label>"+
"<input id=\"payment-cheque_no\" class=\"form-control\" name=\"Payment[cheque_no]\" type=\"text\">"+

"<div class=\"help-block\"></div>"+
"</div>";

      var div = "<br><div class=\"form-group field-payment-file required\">"+
              "<label class=\"control-label\" for=\"payment-file\">File</label>"+
              "<input type=\"hidden\" name=\"Payment[file]\" value=\"\"><input type=\"file\" id=\"payment-file\" name=\"Payment[file]\" aria-required=\"true\">"+

              "<div class=\"help-block\"></div>"+
              "</div>";
      console.log(div);
      $('.hide-div').hide();
      $('#tds_triger').change(function(){
        if($('#tds_triger').val()=='tds'){
          $('.hide-div').slideUp();
          $('.field-payment-file').remove();
        }else{
          $('.hide-div').slideDown();
          $('.hide-div').append(div);
        }

      });

    });
JS;
    $this->registerJS($script);
?>
  <br>
<?php  } else { ?>
  <input id="payment-tds_rate" class="form-control" name="Payment[tds_rate]" value="0" type="hidden">
  <br>
<?php  } ?>
<?php
$script = <<< JS
  $(document).ready(function(){
    var cheque_no ="<br><div class=\"form-group field-payment-cheque_no\">"+
"<label class=\"control-label\" for=\"payment-cheque_no\">Cheque No</label>"+
"<input id=\"payment-cheque_no\" class=\"form-control\" name=\"Payment[cheque_no]\" type=\"text\">"+

"<div class=\"help-block\"></div>"+
"</div>";

    var div = "<br><div class=\"form-group field-payment-file\">"+
            "<label class=\"control-label\" for=\"payment-file\">File</label>"+
            "<input type=\"\" name=\"Payment[file]\" value=\"\"><input type=\"file\" id=\"payment-file\" name=\"Payment[file]\" >"+

            "<div class=\"help-block\"></div>"+
            "</div>";
    console.log(div);


    $('.mode').change(function(){
      if($('.mode').val() == 'cheque'){
        $('.cheque-div').append(cheque_no);
      }else{
        $('.cheque-div').children().remove();
      }
    });
  });
JS;
  $this->registerJS($script);
?>
<div class="form-group">
    <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php  } ?>
