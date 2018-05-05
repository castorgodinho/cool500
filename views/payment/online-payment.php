<?php
  $strCurDate = date('d-m-Y');
  $amount= $model->grand_total;

?>

<h1>Payment Details</h1>

<table class="table table-bordered">
    <tr>
        <td>Date</td>
        <td><?= $strCurDate ?></td>
    </tr>
    <tr>
        <td>Invoice code</td>
        <td><?= $model->invoice_code ?></td>
    </tr>
    <tr>
        <td>Company Name</td>
        <td><?= $model->order->company->name ?></td>
    </tr>
    <tr>
        <td>Amount Payable</td>
        <td><?= $amount ?></td>
    </tr>
</table>





<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->



<form method="post" id="payment-form" action="http://172.20.1.158/gidc/payment/post_request.php">

<br/>
 
<input type="hidden" name="mrctTxtID" value="999999"/>
<input type="hidden" name="locatorURL" value="https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl"/>
<input type="hidden" name="txnDate" value="<?php echo $strCurDate;?>"/>
<input type="hidden" name="custID" value="<?= $model->order->company_id ?>"/>
<input type="hidden" name="custname" value="<?= $model->order->company->name ?>"/><br>
<input type="hidden" name="test" value="data"/><br>
<input type="text" class='amount' class="form-control" name="amount" value="<?php echo $amount; ?>"/>
<input type="hidden" name="reqType" value="T"/>
<input type="hidden" name="mrctCode" value="T143310"/>
<input type="hidden" name="currencyType" value="INR"/>
<input type="hidden" name="bankCode" value="470"/>
<input type="hidden" name="returnURL" value='http://172.20.1.158/gidc/payment/post_response.php'/>
<input type="hidden" name="s2SReturnURL" value="https://tpslvksrv6046/LoginModule/Test.jsp"/>   
<input type="hidden" name="tpsl_txn_id" value="TXN00111"/>
<input type="hidden" name="reqDetail" class="amount-hidden" value="Test_<?php echo $amount; ?>_0.0"/>

<h2><?= $model->invoice_id ?></h2>
<h2><?= $model->start_date ?></h2>
<h2><?= $model->order_id ?></h2>


 <input type="submit" class="submit-btn btn btn-primary" name="submit" value="Pay Now" />
 
 </form>

<?php 
    $script = <<< JS
    $(document).ready(function(){
        $('#payment-form').submit(function(){
            var amount = $('.amount').val();
            if(amount.indexOf(".") == -1){
                console.log("Decimal");
                amount = Number($('.amount').val()).toFixed(1);
            }
            $('.amount').val(amount);
            console.log(amount.toString());
            var amt_value = 'Test_'+amount+"_0.0";
            $('.amount-hidden').val(amt_value);
        });
    });
JS;
$this->registerJS($script);
?>