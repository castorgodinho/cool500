<?php
  $strCurDate = date('d-m-Y');
  $amount=100.0;

?>









<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->

Date : <?php echo $strCurDate;?>    <br/>

Amount Payable : <?php echo $amount; ?>.0       <br/>



<form method="post" action="http://172.20.1.158/gidc_payment/post_request.php">

<br/>

<input type="hidden" name="mrctTxtID" value="999999"/> //unique number
<input type="hidden" name="locatorURL" value="https://www.tekprocess.co.in/PaymentGateway/TransactionDetailsNew.wsdl"/>
<input type="hidden" name="txnDate" value="<?php echo $strCurDate;?>"/>
<input type="hidden" name="custID" value="11111"/> //Unit ID
<input type="hidden" name="custname" value="SAMIHAN KUTTAN"/> //Comany Name/Unit number
<input type="hidden" name="amount" value="<?php echo $amount; ?>.0"/>
<input type="hidden" name="reqType" value="T"/>
<input type="hidden" name="mrctCode" value="T143310"/>
<input type="hidden" name="currencyType" value="INR"/>
<input type="hidden" name="bankCode" value="470"/>
<input type="hidden" name="returnURL" value='http://172.20.1.158/gidc_payment/post_response.php'/>
<input type="hidden" name="s2SReturnURL" value="https://tpslvksrv6046/LoginModule/Test.jsp"/>
<input type="hidden" name="tpsl_txn_id" value="TXN00111"/>
<input type="hidden" name="reqDetail" value="Test_<?php echo $amount; ?>.0_0.0"/>












 <input type="submit" name="submit" value="Submit" />

 </form>
