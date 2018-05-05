<?php

namespace app\models;
use app\models\Payment;
use app\models\Invoice;
use yii\web\UploadedFile;

use Yii;

class MyPayment extends Payment
{
    public function generate(){
      if ($this->load(Yii::$app->request->post())) {

        $invoice = Invoice::findOne($this->invoice_id);
        $currentPenalInterest = $invoice->current_interest;
        echo '$currentPenalInterest '.$currentPenalInterest.'<br>';
        $invoice->save();
        echo '$invoice->invoice_id '.$this->invoice_id.'<br>';

        $totalPreviousPayment = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->sum('amount');

        $totalLeaseRentPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->sum('lease_rent');

        $totalPenalPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->sum('penal');

        $totalTaxPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->sum('tax');

        echo '$totalPreviousPayment '.$totalPreviousPayment.'<br>';
        echo '$totalPenalPaid '.$totalPenalPaid.'<br>';
        echo '$totalTaxPaid '.$totalTaxPaid.'<br>';
        echo '$totalLeaseRentPaid '.$totalLeaseRentPaid.'<br>';
        echo '$this->amount '.$this->amount.'<br>';

        $balanceAmount = $this->amount - $totalPreviousPayment;
        echo '$balanceAmount '.$balanceAmount.'<br>';
        $currentLeaseRent = $invoice->current_lease_rent;
        echo '$currentLeaseRent '.$currentLeaseRent.'<br>';
        $previousLeaseRent = $invoice->prev_lease_rent;
        echo '$previousLeaseRent '.$previousLeaseRent.'<br>';
        $previousTax = $invoice->prev_tax;
        echo '$previousTax '.$previousTax.'<br>';
        $currentTax = $invoice->current_tax;
        echo '$currentTax '.$currentTax.'<br>';
        $previousDuesTotal = $invoice->prev_dues_total;
        echo '$previousDuesTotal '.$previousDuesTotal.'<br>';
        $previousPenalInterest = $invoice->prev_interest;
        echo '$previousPenalInterest '.$previousPenalInterest.'<br>';
        echo '$currentPenalInterest '.$currentPenalInterest.'<br>';

        $totalTax = 0;
        $totalLeaseRent = 0;
        $totalPenalInterest = 0;
        $totalPenalInterest = $currentPenalInterest + $previousPenalInterest;
        if($previousDuesTotal != 0 ){
          $totalTax = $previousTax +  $currentTax;
          $totalLeaseRent = $previousLeaseRent + $currentLeaseRent;
        }else{
          $totalTax = $currentTax;
          $totalLeaseRent = $currentLeaseRent;
        }
        $totalRentPlusTax = $totalTax + $totalLeaseRent;
        echo '$totalRentPlusTax '.$totalRentPlusTax.'<br>';

        $totalInvoiceAmount =  $invoice->grand_total + $totalPenalInterest;
        echo '$totalInvoiceAmount '.$totalInvoiceAmount.'<br>';
        echo '$totalTax '.$totalTax.'<br>';
        echo '$totalLeaseRent '.$totalLeaseRent.'<br>';
        echo '$totalPenalInterest '.$totalPenalInterest.'<br>';

        $totalTaxPending = $totalTax - $totalTaxPaid;
        $totalLeasePending = $totalLeaseRent - $totalLeaseRentPaid;
        $totalPenalPending = $totalPenalInterest - $totalPenalPaid;

        echo '$totalTaxPending '.$totalTaxPending.'<br>';
        echo '$totalPenalPending '.$totalPenalPending.'<br>';
        echo '$totalLeasePending '.$totalLeasePending.'<br>';

        $totalPending = $totalTaxPending + $totalLeasePending;

        echo '$totalPending '.$totalPending.'<br>';

        $amountPaying = $this->amount;
        echo '$amountPaying '.$amountPaying.'<br>';

        $taxPerectage = ($totalTax * 100) / $totalPending;
        $leasePerectage = ($totalLeaseRent * 100) / $totalPending;

        echo '$taxPerectage '.$taxPerectage.'<br>';
        echo '$leasePerectage '.$leasePerectage.'<br>';

        $taxPaying = $amountPaying * ($taxPerectage/100);
        $leasePaying = $amountPaying * ($leasePerectage/100);

        echo '$taxPaying '.$taxPaying.'<br>';
        echo '$leasePaying '.$leasePaying.'<br>';

        $a = $amountPaying - ($taxPaying + $leasePaying) - $totalPenalPending ;
        echo '$a '.$a.'<br>';

        $totalPaying = $taxPaying + $leasePaying;
        echo '$totalPaying '.$totalPaying.'<br>';

        $penalPayment = 0;
        if($amountPaying > $totalRentPlusTax ){

          $taxPaying = $totalRentPlusTax * ($taxPerectage/100);
          $leasePaying = $totalRentPlusTax * ($leasePerectage/100);
          $penalPayment = $amountPaying - $totalRentPlusTax;
          echo '$taxPaying '.$taxPaying.'<br>';
          echo '$penalPayment '.$penalPayment.'<br>';
          echo '$leasePaying '.$leasePaying.'<br>';
        }

        $this->penal = $penalPayment;
        $this->tax = $taxPaying;
        $this->lease_rent = $leasePaying;

          if($balanceAmount < 0){
            Yii::$app->session->setFlash('danger', "TRYING TO PAY EXTRA");
            return $this->redirect(['index']);
          }
          else if($this->tds_rate > 10.10 ){
            Yii::$app->session->setFlash('danger', "TDS HAS TO BE LESS THAN 10.10");
            return $this->redirect(['index']);
          }
          else{
              $this->save(False);
              $payment_no = 'GIDC/';
              $payment_id = strval($this->payment_id);
              for ($i=0; $i < (7 - strlen($payment_id)); $i++) {
                $payment_no = $payment_no .'0';
              }
              $payment_no = $payment_no .''. $payment_id;
              $this->payment_no = $payment_no;
              $this->balance_amount = $balanceAmount;

              $this->file = UploadedFile::getInstance($this, 'file'); #TODO
              if($this->file){
                $this->tds_file = 'gstfiles/' . $this->payment_id . '.' . $this->file->extension;
                $this->file->saveAs('gstfiles/' . $this->payment_id . '.' . $this->file->extension);
              }
              $lr = $this->invoice->current_lease_rent;
              $tds_amount = ($lr * ($this->tds_rate/100));
              $this->tds_amount = $tds_amount;
              $this->save(False);
          }
      }
 }
}
