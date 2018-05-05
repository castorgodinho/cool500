<?php 
    use app\models\Ledger;
    use yii\helpers\Html;
?>

<h1>Ledger</h1>

<?php $form = Html::beginForm(); ?>
<form action="<?=  \Yii::$app->request->BaseUrl ?>/index.php?r=report%2Fledger" method="POST">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<?php if(Yii::$app->user->can('admin')){?>
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <?= Html::label('From Date', 'xxx') ?>
        <?=  \yii\jui\DatePicker::widget([
            'name'  => 'from_date',
            'value'  => '',
            'options' => [
                'class' => 'form-control',
            ],
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ]);?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <?= Html::label('To Date', 'xxx') ?>
        <?=  \yii\jui\DatePicker::widget([
            'name'  => 'to_date',
            'value'  => '',
            'options' => [
                'class' => 'form-control',
            ],
            //'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
        ]);?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <br>
        <input type="text" class="form-control" name="order_number" placehoder="Order Number">
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <br>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
        <?php } ?>





</form>

<h3> <?= $to ?> -  <?= $from ?></h3>

<br><br>
<table class="table table-bordered">
    <thead>
        <td>Sr. No</td>
        <td>Particulars</td>
        <td>Date</td>
        <td>Debit</td>
        <td>Credit</td>
    </thead>
    <?php 
        $status = True;
        $invoice_i = 0;
        $payment_i = 0;
        $led = array();
        $invoice_total = 0;
        $payment_total = 0;
        foreach($invoice as $in){
            array_push($led, new Ledger($in->invoice_code, $in->start_date, $in->grand_total, True ));
            $invoice_total += $in->grand_total;
        }
        foreach($payment as $pay){
            array_push($led, new Ledger($pay->payment_id, $pay->start_date, $pay->amount, False ));
            $payment_total += $pay->amount;
        } 
        foreach($debit as $deb){
            if($deb->penal > 0){
                array_push($led, new Ledger($deb->debit_id, $deb->start_date, $deb->penal, True ));
                $invoice_total += $deb->penal;
            }
            
        } 
        function cmp($a, $b)
        {
            return strcmp($a->date, $b->date);
        }

        usort($led, "cmp");
        $debitTotal = 0;
        $creditTotal = 0;
        $sr_no = 1;
        foreach($led as $record){
            $creditAmount = 0;
            $debitAmount = 0;
            if($record->isCredit){
                $debitAmount = $record->amount; 
                $debitTotal += $debitAmount;
            }else{
                $creditAmount = $record->amount; 
                $creditTotal += $creditAmount;
            }
            echo "<tr> <td>$sr_no</td> <td>". $record->particulars ."</td> <td>". $record->date ."</td><td>$debitAmount</td><td>$creditAmount</td></tr>";
            $sr_no = $sr_no + 1;
        }
        $outstanding = ($invoice_total - $payment_total);
        echo "<tr> <td>#</td> <td>Outstanding</td> <td> </td><td></td><td>". $outstanding ."</td></tr>";
        echo "<tr> <td>#</td> <td>Total</td> <td> </td><td>". $debitTotal ."</td><td>". ($outstanding + $creditTotal) ."</td></tr>";
    ?>
</table>