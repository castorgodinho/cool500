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

  public static function calculatePenalInterest($order,$interest,$diffDate){
    $totalLeaseRent = MyInvoice::getTotalLeaseRent($order);
    $totalLeaseRentPaid = MyInvoice::getTotalLeaseRentPaid($order);
    $balanceLeaseRent = $totalLeaseRent - $totalLeaseRentPaid;
    $penalAmount = 0;
    // Penal intrest needs to be paid
    if($balanceLeaseRent != 0){
      if($diffDate > 0){
        $penalAmount = (($diffDate  * ($interest->rate)/100) * $balanceLeaseRent ) / 365;
        }
    }
    return $penalAmount;
  }

    public static function getTotalAmountPaid($order){
      $amount = Payment::find()->where(['order_id' => $order->order_id])
      ->sum('amount');
      return $amount;
    }

    public function generatePayment($status,$controller) {
      if ($this->load(Yii::$app->request->post())) {
        $pi = $this->penal;
        echo '$this->penal '.$this->penal.'<br>';
        $invoice = Invoice::findOne($this->invoice_id);
        $order = Orders::findOne($this->order_id);
        $totalPenal = MyInvoice::getTotalPenal($order) + $pi;
        $totalPenalPaid = MyInvoice::getTotalPenalPaid($order);
        $balancePenal = $totalPenal - $totalPenalPaid;
        $totalAmount = MyInvoice::getTotalAmount($order);
        $totalAmountPaid = MyPayment::getTotalAmountPaid($order);
        $totalLeaseRent = MyInvoice::getTotalLeaseRent($order);
        $totalLeaseRentPaid = MyInvoice::getTotalLeaseRentPaid($order);
        $totalTaxPaid = MyInvoice::getTotalTaxPaid($order);
        $totalTax = MyInvoice::getTotalTax($order);
        $balanceAmount = $totalAmount + $totalPenal - $totalAmountPaid;
        $balanceTax = $totalTax - $totalTaxPaid;
        $balanceLease = $totalLeaseRent - $totalLeaseRentPaid;
        echo '$totalPenal '.$totalPenal.'<br>';
        echo '$totalPenalPaid '.$totalPenalPaid.'<br>';
        echo '$balancePenal '.$balanceAmount.'<br>';
        echo '$pi '.$pi.'<br>';
        echo '$balanceAmount'.$balanceAmount.'<br>';
        echo '$balancePenal'.$balancePenal.'<br>';
        echo '$totalAmount'.$totalAmount.'<br>';
        echo '$totalAmountPaid'.$totalAmountPaid.'<br>';
        echo '$this->amount'.$this->amount.'<br>';
        if($this->amount > $balanceAmount ){ //Trying to pay extra
          Yii::$app->session->setFlash('danger', "TRYING TO PAY EXTRA");
          return $controller->redirect(['invoice/view' ,'id' => $invoice->invoice_id]);
        }
        $totalTaxAndLease =  $balanceTax + $balanceLease;
        if($totalTaxAndLease != 0){
          $taxPerectage = ($totalTax * 100) / $totalTaxAndLease;
          $leasePerectage = ($totalLeaseRent * 100) / $totalTaxAndLease;
        }else{
          $taxPerectage = 0;
          $leasePerectage = 0;
        }
        echo '$totalTaxAndLease'.$totalTaxAndLease.'<br>';
        echo '$taxPerectage'.$taxPerectage.'<br>';
        echo '$leasePerectage'.$leasePerectage.'<br>';
        if($this->amount >= ($totalTaxAndLease)){
              $totalTaxPaying = $balanceTax;
              $totalLeasePaying = $balanceLease;
        if($balanceAmount == $this->amount){
              echo 'FULL payment LR + GST + Penal  <br>';
              $this->penal = $balancePenal;
              $this->balance_amount = 0;
          }else{
              echo 'FULL LR + GST  PARTAL Peenal <br>';
                $balancePenalNotPaid = $this->amount - ($balanceTax + $balanceLease);
                $this->penal = $balancePenalNotPaid;
                echo '$this->amount '.$this->amount .'<br>';
                echo '$balanceTax '.$balanceTax .'<br>';
                echo '$balanceLease '.$balanceLease .'<br>';
                echo '$this->penal '.$this->penal.'<br>';
                echo '$balancePenalNotPaid '.$balancePenalNotPaid.'<br>';
          }
        }else{
          echo 'PARTAL LR + GST Cleared <br>';
          $totalTaxAndLease = $this->amount;
          $totalTaxPaying = ($taxPerectage/100) * $totalTaxAndLease;
          $totalLeasePaying = ($leasePerectage/100) * $totalTaxAndLease;
          $this->penal = 0;
        }
        echo '$totalTaxPaying'.$totalTaxPaying.'<br>';
        echo '$totalLeasePaying'.$totalLeasePaying.'<br>';
        $this->lease_rent = round($totalLeasePaying);
        $this->tax = round($totalTaxPaying);
        $this->file = UploadedFile::getInstance($this, 'file');
        if($this->file){
          $this->tds_file = 'tdsfiles/' . $this->file->baseName . '.' . $this->file->extension;
          $this->file->saveAs('tdsfiles/' .$this->file->baseName . '.' . $this->file->extension);
        }
        $this->balance_amount =  $balanceAmount;
        $this->status =  $status;
        $this->save(False);
         //Generate Debit Note
          if($pi > 0){
            $debit = new Debit();
            $debit->penal = $pi;
            $debit->invoice_id = $invoice->invoice_id;
            $debit->order_id = $invoice->order->order_id;
            $debit->payment_id = $this->payment_id;
            $debit->save(False);
          }
        echo '$this->lease_rent'.$this->lease_rent.'<br>';
      }
    }


}
