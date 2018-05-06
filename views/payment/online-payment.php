<?php
  $strCurDate = date('d-m-Y');
  $amount= $model->amount;

?>



<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->



<form method="post" id="payment-form" action="http://192.168.1.9/gidc/payment/post_request.php">

<br/>
 
<input type="hidden" name="mrctTxtID" value="<?= $model->payment_id ?>"/>
<input type="hidden" name="locatorURL" value="https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl"/>
<input type="hidden" name="txnDate" value="<?php echo $strCurDate;?>"/>
<input type="hidden" name="custID" value="<?= $model->order->company_id ?>"/>
<input type="hidden" name="custname" value="<?= $model->payment_id ?>"/><br>
<input type="hidden" name="test" value="data"/><br>
<input type="hidden" class='amount' class="form-control" name="amount" value="<?php echo $amount; ?>"/>
<input type="hidden" name="reqType" value="T"/>
<input type="hidden" name="mrctCode" value="T143310"/>
<input type="hidden" name="currencyType" value="INR"/>
<input type="hidden" name="bankCode" value="470"/>
<input type="hidden" name="returnURL" value='http://192.168.1.9/gidc/payment/post_response.php'/>
<input type="hidden" name="s2SReturnURL" value="https://tpslvksrv6046/LoginModule/Test.jsp"/>   
<input type="hidden" name="tpsl_txn_id" value="TXN00111"/>
<input type="hidden" name="reqDetail" class="amount-hidden" value="Test_<?php echo $amount; ?>_0.0"/>


<div class="jumbotron">
    <div class="container">
        <h1>Redirecting to payment gateway.</h1>
        <p>Please wait ...</p>
        <p>
            
        </p>
    </div>
</div>


 </form>

<?php 
    $script = <<< JS
    $(document).ready(function(){
        var amount = $('.amount').val();
        if(amount.indexOf(".") == -1){
            console.log("Decimal");
            amount = Number($('.amount').val()).toFixed(1);
        }
        $('.amount').val(amount);
        console.log(amount.toString());
        var amt_value = 'Test_'+amount+"_0.0";
        $('.amount-hidden').val(amt_value);
        $('#payment-form').submit();
    });
JS;
$this->registerJS($script);
?>