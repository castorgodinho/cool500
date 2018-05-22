<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['action' => 'index.php?r=payment/create', 'id' => 'form1', 'options' => ['enctype' => 'multipart/form-data']]); ?>

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
    <td>  Current Penal Amount </td>
    <td> <?= round($model->penal) ?>  </td>
  </tr>

  <tr>
    <td>  Current Due Total </td>
    <td> <?= $invoice->current_dues_total ?>  </td>
  </tr>

  <tr>
    <td>  Final Total ( C = A + B) </td>
    <td> <?= $invoice->total_amount?>  </td>
  </tr>

  <tr>
    <td>  <h2>BALANCE</h2> </td>
    <td> <h3><?= round($balanceAmount) ?></h3>  </td>
  </tr>


</table>
<?php if($balanceAmount != 0) { ?>

<p> <b>Amount:</b> </p>

<input id="mypayment-invoice_id" class="form-control" name="MyPayment[invoice_id]" value="<?= $model->invoice_id ?>" aria-invalid="false" type="hidden">

<input id="mypayment-amount" class="form-control amount-1" name="MyPayment[amount]" type="text">
<br>
<input id="mypayment-start_date" class="form-control" name="MyPayment[start_date]" value="<?= $model->start_date?>" type="hidden">

<input id="mypayment-order_id" class="form-control" name="MyPayment[order_id]" value="<?= $model->order_id?>" type="hidden">

<input id="mypayment-penal" class="form-control" name="MyPayment[penal]" value="<?= round($model->penal) ?>" type="hidden">

<input id="mypayment-lease_rent" class="form-control" name="MyPayment[lease_rent]" value="<?= $model->lease_rent ?>" type="hidden">

<input id="mypayment-tax" class="form-control" name="MyPayment[tax]" value="<?= $model->tax ?>" type="hidden">

<input id="mypayment-balance_amount" class="form-control" name="MyPayment[balance_amount]" value="<?= round($balanceAmount) ?>" type="hidden">

<?php if(\Yii::$app->user->can('admin')){ ?>
  <input id="mypayment-status" class="form-control" name="MyPayment[status]" value="1" type="hidden">
<?php }else{ ?>
  <input id="mypayment-status" class="form-control" name="MyPayment[status]" value="0" type="hidden ">
<?php } ?>


<?php if(\Yii::$app->user->can('admin')){ ?>
  <?= $form->field($model, 'mode')->dropDownList([ 'cash' => 'CASH', 'cheque' => 'CHEQUE','card' => 'CARD' ], ['prompt' => '', 'class' => 'mode form-control']) ?>
  <?= $form->field($model, 'cheque_no')->textInput(); ?>
<?php }else{ ?>
  <?= $form->field($model, 'mode')->dropDownList(['online' => 'ONLINE' ], ['class' => 'mode form-control']) ?>
<?php } ?>

<div class="cheque-div">

</div>

  <label for="">TDS</label>
  <select id='tds_triger' class="form-control" name="tds">
    <option value="tds">NO TDS</option>
    <option value="no-tds">TDS</option>
  </select>


  <div class="hide-div">
    <br>
  <label for="">TDS AMOUNT</label>
    <input id="mypayment-tds_amount" class="form-control" name="MyPayment[tds_amount]" value="0" type="text">
    <?= $form->field($model, 'file')->fileInput() ?>
  </div>
  <?php
  $script = <<< JS
    $(document).ready(function(){
      var cheque_no ="<br><div class=\"form-group field-mypayment-cheque_no\">"+
"<label class=\"control-label\" for=\"mypayment-cheque_no\">Cheque No</label>"+
"<input id=\"mypayment-cheque_no\" class=\"form-control\" name=\"MyPayment[cheque_no]\" type=\"text\">"+

"<div class=\"help-block\"></div>"+
"</div>";

      var div = "<br><div class=\"form-group field-mypayment-file required\">"+
              "<label class=\"control-label\" for=\"mypayment-file\">File</label>"+
              "<input type=\"text\" name=\"MyPayment[file]\" value=\"\"><input type=\"file\" id=\"mypayment-file\" name=\"MyPayment[file]\" aria-required=\"true\">"+

              "<div class=\"help-block\"></div>"+
              "</div>";
      console.log(div);
      $('.hide-div').hide();
      $('#tds_triger').change(function(){
        if($('#tds_triger').val()=='tds'){
          $('.hide-div').slideUp();
          //$('.field-payment-file').remove();
        }else{
          $('.hide-div').slideDown();
          //$('.hide-div').append(div);
        }
      });
    });
JS;
    $this->registerJS($script);
?>
  <br>

<?php
$script = <<< JS
  $(document).ready(function(){
    var cheque_no ="<br><div class=\"form-group field-mypayment-cheque_no\">"+
"<label class=\"control-label\" for=\"mypayment-cheque_no\">Cheque No</label>"+
"<input id=\"mypayment-cheque_no\" class=\"form-control\" name=\"MyPayment[cheque_no]\" type=\"text\">"+

"<div class=\"help-block\"></div>"+
"</div>";

    var div = "<br><div class=\"form-group field-mypayment-file\">"+
            "<label class=\"control-label\" for=\"mypayment-file\">File</label>"+
            "<input type=\"\" name=\"MyPayment[file]\" value=\"\"><input type=\"file\" id=\"mypayment-file\" name=\"MyPayment[file]\" >"+

            "<div class=\"help-block\"></div>"+
            "</div>";
    console.log(div);

    $('.field-mypayment-cheque_no').hide();
    $('.mode').change(function(){
      if($('.mode').val() == 'cheque'){
        $('.field-mypayment-cheque_no').show();
        //$('.cheque-div').append(cheque_no);
      }else{
        $('.field-mypayment-cheque_no').hide();
        //$('.cheque-div').children().remove();
      }
    });
  });
JS;
  $this->registerJS($script);
?>
<div class="form-group">
    <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success', 'id' => '']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php  } ?>
