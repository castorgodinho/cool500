<?php

ob_start();


date_default_timezone_set('Asia/Calcutta');

//echo date_default_timezone_get();

$strCurDate = date('d-m-Y');

require_once 'TransactionRequestBean.php';
require_once 'TransactionResponseBean.php';

session_start();

if($_POST && isset($_POST['submit'])){


}else if($_POST){
    
    $mrctCode="T143310";
    $iv="6014291051IBXWQV";
    $key="6636259131GPLFAX";

    $response = $_POST;

    if(is_array($response)){
        $str = $response['msg'];
    }else if(is_string($response) && strstr($response, 'msg=')){
        $outputStr = str_replace('msg=', '', $response);
        $outputArr = explode('&', $outputStr);
        $str = $outputArr[0];
    }else {
        $str = $response;
    }

    $transactionResponseBean = new TransactionResponseBean();

    $transactionResponseBean->setResponsePayload($str);
    $transactionResponseBean->setKey($key);
    $transactionResponseBean->setIv($iv);

    $response = $transactionResponseBean->getResponsePayload();
    echo "<pre>";
    print_r($response);
    /* foreach($response as $data){
        echo $data . '<br>';
    } */
    $status = explode("|",$response);
    echo $status[1];
     echo "</pre>";
    echo "<br><br><br><br>";

    session_destroy();?>

    <a href='<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER['SCRIPT_NAME'];?>'>GO TO HOME</a>

    <?php
    exit;
}

?>