<?php

namespace app\models;
use app\models\Payment;
use app\models\Invoice;
use app\models\MyInvoice;
use yii\web\UploadedFile;
use app\models\Debit;

use Yii;

class MyPayment extends Payment
{
    public function generate(){
      if ($this->load(Yii::$app->request->post())) {

        $invoice = Invoice::findOne($this->invoice_id);
        $currentPenalInterest = 0;
        /// '$currentPenalInterest '.$currentPenalInterest.'<br>';
        $invoice->save();
        /// '$invoice->invoice_id '.$this->invoice_id.'<br>';

        $totalPreviousPayment = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->andWhere(['status' => 1])
        ->sum('amount');

        $totalLeaseRentPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->andWhere(['status' => 1])
        ->sum('lease_rent');

        $totalPenalPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->andWhere(['status' => 1])
        ->sum('penal');

        $totalTaxPaid = Payment::find()
        ->where(['invoice_id' => $this->invoice_id])
        ->andWhere(['status' => 1])
        ->sum('tax');

        /// '$totalPreviousPayment '.$totalPreviousPayment.'<br>';
        /// '$totalPenalPaid '.$totalPenalPaid.'<br>';
        /// '$totalTaxPaid '.$totalTaxPaid.'<br>';
        /// '$totalLeaseRentPaid '.$totalLeaseRentPaid.'<br>';
        /// '$this->amount '.$this->amount.'<br>';

        $totalAmount = MyInvoice::getTotalAmount($invoice->order);
        $totalAmountPaid = MyInvoice::getTotalAmountPaid($invoice->order);

        $balanceAmount = $totalAmount - $totalAmountPaid;
        /// '$balanceAmount '.$balanceAmount.'<br>';
        $currentLeaseRent = $invoice->current_lease_rent;
        /// '$currentLeaseRent '.$currentLeaseRent.'<br>';
        $previousLeaseRent = $invoice->prev_lease_rent;
        /// '$previousLeaseRent '.$previousLeaseRent.'<br>';
        $previousTax = $invoice->prev_tax;
        /// '$previousTax '.$previousTax.'<br>';
        $currentTax = $invoice->current_tax;
        /// '$currentTax '.$currentTax.'<br>';
        $previousDuesTotal = $invoice->prev_dues_total;
        /// '$previousDuesTotal '.$previousDuesTotal.'<br>';
        $previousPenalInterest = $invoice->prev_interest;
        /// '$previousPenalInterest '.$previousPenalInterest.'<br>';
        /// '$currentPenalInterest '.$currentPenalInterest.'<br>';

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
        /// '$totalRentPlusTax '.$totalRentPlusTax.'<br>';

        $totalInvoiceAmount =  $invoice->total_amount + $totalPenalInterest;
        /// '$totalInvoiceAmount '.$totalInvoiceAmount.'<br>';
        /// '$totalTax '.$totalTax.'<br>';
        /// '$totalLeaseRent '.$totalLeaseRent.'<br>';
        /// '$totalPenalInterest '.$totalPenalInterest.'<br>';

        $totalTaxPending = $totalTax - $totalTaxPaid;
        $totalLeasePending = $totalLeaseRent - $totalLeaseRentPaid;
        $totalPenalPending = $totalPenalInterest - $totalPenalPaid;

        /// '$totalTaxPending '.$totalTaxPending.'<br>';
        /// '$totalPenalPending '.$totalPenalPending.'<br>';
        /// '$totalLeasePending '.$totalLeasePending.'<br>';

        $totalPending = $totalTaxPending + $totalLeasePending;

        /// '$totalPending '.$totalPending.'<br>';

        $amountPaying = $this->amount;
        /// '$amountPaying '.$amountPaying.'<br>';

        $taxPerectage = ($totalTax * 100) / $totalPending;
        $leasePerectage = ($totalLeaseRent * 100) / $totalPending;

        /// '$taxPerectage '.$taxPerectage.'<br>';
        /// '$leasePerectage '.$leasePerectage.'<br>';

        $taxPaying = $amountPaying * ($taxPerectage/100);
        $leasePaying = $amountPaying * ($leasePerectage/100);

        /// '$taxPaying '.$taxPaying.'<br>';
        /// '$leasePaying '.$leasePaying.'<br>';

        $a = $amountPaying - ($taxPaying + $leasePaying) - $totalPenalPending ;
        /// '$a '.$a.'<br>';

        $totalPaying = $taxPaying + $leasePaying;
        /// '$totalPaying '.$totalPaying.'<br>';

        $penalPayment = 0;

        $leasePaying = MyInvoice::getTotalLeaseRent($invoice->order);
        echo '$leasePaying'.$leasePaying.'<br>';
        $this->lease_rent = $leasePaying;
        $this->save(False);
        echo '$this->lease_rent'.$this->lease_rent.'<br>';
        if($amountPaying > $totalRentPlusTax ){

          $taxPaying = $totalRentPlusTax * ($taxPerectage/100);
          $leasePaying = $totalRentPlusTax * ($leasePerectage/100);
          $penalPayment = $amountPaying - $totalRentPlusTax;
          /// '$taxPaying '.$taxPaying.'<br>';
          /// '$penalPayment '.$penalPayment.'<br>';
          /// '$leasePaying '.$leasePaying.'<br>';
        }

        $this->penal = $penalPayment;
        $this->tax = $taxPaying;

        if($balanceAmount < 0){
          Yii::$app->session->setFlash('danger', "TRYING TO PAY EXTRA");
          return $this->redirect(['index']);
        }
        else if($this->tds_rate > 10.10 ){
          Yii::$app->session->setFlash('danger', "TDS HAS TO BE LESS THAN 10.10");
          return $this->redirect(['index']);
        }else{
          //$this->status = 1;
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
            $this->tds_file = 'tdsfiles/' . $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs('tdsfiles/' .$this->file->baseName . '.' . $this->file->extension);
          }
          //$this->tds_file = ''
          $lr = $this->invoice->current_lease_rent;
          $tds_amount = ($lr * ($this->tds_rate/100));
          $this->tds_amount = $tds_amount;
          //$this->status = 1;
          $this->save(False);

          $debit = new Debit();
          $debit->penal = $this->penal;
          $debit->invoice_id = $invoice->invoice_id;
          $debit->payment_id = $this->payment_id;
          $debit->order_id = $invoice->order->order_id;
          $debit->save(False);
        }
      }
  }
}
