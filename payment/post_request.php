<?php

ob_start();



date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();



require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';

session_start();

if($_POST){    
    
     $val = $_POST;
    
     print "<script>console.log('--IN POST--');</script>";
    
    $mrctCode="";
    $iv="";
    $key="";

    $mrctCode="T143310";
    $iv="6014291051IBXWQV";
    $key="6636259131GPLFAX";
    
    print "<script>console.log('iv : '+$iv);</script>";
    print "<script>console.log('key : '+$key);</script>";
    print "<script>console.log('custID : '+".$val['custID'].");</script>";

   

//    $_SESSION['iv'] = $iv;
//    $_SESSION['key']   = $key;
    
    
    
    
    print"<pre>";
    //print_r($val);
    print"</pre>";
    
    $transactionRequestBean = new TransactionRequestBean();

    //Setting all values here
    $transactionRequestBean->setMerchantCode($mrctCode);
//    $transactionRequestBean->setAccountNo($val['tpvAccntNo']);
//    $transactionRequestBean->setITC($val['itc']);
//    $transactionRequestBean->setMobileNumber($val['mobNo']);
    $transactionRequestBean->setCustomerName($val['custname']);
    $transactionRequestBean->setRequestType($val['reqType']);
    $transactionRequestBean->setMerchantTxnRefNumber($val['mrctTxtID']);
    $transactionRequestBean->setAmount($val['amount']);
    $transactionRequestBean->setCurrencyCode($val['currencyType']);
    $transactionRequestBean->setReturnURL($val['returnURL']);
    $transactionRequestBean->setS2SReturnURL($val['s2SReturnURL']);
    $transactionRequestBean->setShoppingCartDetails($val['reqDetail']);
    $transactionRequestBean->setTxnDate($val['txnDate']);
    $transactionRequestBean->setBankCode($val['bankCode']);
    $transactionRequestBean->setTPSLTxnID($val['tpsl_txn_id']);
    $transactionRequestBean->setCustId($val['custID']);
    
    $transactionRequestBean->setKey($key);
    $transactionRequestBean->setIv($iv);
    $transactionRequestBean->setWebServiceLocator($val['locatorURL']);
   
//    $transactionRequestBean->setTimeOut($val['timeOut']);

   // $url = $transactionRequestBean->getTransactionToken();

    $responseDetails = $transactionRequestBean->getTransactionToken();     
    $responseDetails = (array)$responseDetails;
    $response = $responseDetails[0];
  

    if(is_string($response) && preg_match('/^msg=/',$response)){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];

        $transactionResponseBean = new TransactionResponseBean();
        $transactionResponseBean->setResponsePayload($str);
        $transactionResponseBean->setKey($val['key']);
        $transactionResponseBean->setIv($val['iv']);

        $response = $transactionResponseBean->getResponsePayload();
        echo "<pre>";
        print_r($response);
        exit;
    }elseif(is_string($response) && preg_match('/^txn_status=/',$response)){
        print_r($response);
        exit;
	}

    echo "<script>window.location = '".$response."'</script>";
    ob_flush();

}else if($_POST){

   
    echo "DEstroyed..";
    session_destroy();
    

    exit;
}

?>