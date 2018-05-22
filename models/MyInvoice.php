<?php

namespace app\models;
use app\models\Invoice;
use app\models\OrderRate;
use app\models\Orders;
use app\models\Payment;
use app\models\Debit;
use app\models\Interest;
use app\models\Tax;

use Yii;

class MyInvoice extends Invoice
{

    public static function createInvoices(){
      $orders = Orders::find()->all();
      foreach ($orders as $order) {
        $invoice = Invoice::find()->where(['order_id' => $order->order_id])
        ->orderBy(['invoice_id' => SORT_DESC])
        ->one();
        if($invoice){
          $diffDate = MyInvoice::getDateDifference($invoice->due_date);
          if($diffDate == 0 ){
            MyInvoice::generateInvoice($order);
          }
        }
      }
    }

    public static function generateInvoiceCode($areaCode){
      date_default_timezone_set('Asia/Kolkata');
      $year = date('Y');
      $year = substr($year,2,3);
      $invoiceCode = $areaCode . '/' . $year;
      $year = intval($year) + 1;
      $invoiceCode = $invoiceCode . '-' . $year;
      $latestInvoice = Invoice::find()
      ->orderBy(['invoice_id' => SORT_DESC])
      ->one();
      if($latestInvoice){
        $invoiceID = strval($latestInvoice->invoice_id+1);
      }
      else{
        $invoiceID = '1';
      }
      $len = strlen($invoiceID);
      for ($i=0; $i < (4 - $len); $i++) {
        $invoiceID = '0'. $invoiceID;
      }
      $invoiceCode = $invoiceCode . '/' . $invoiceID;
      return $invoiceCode;
    }

    public static function getDateDifference($date){
      date_default_timezone_set('Asia/Kolkata');
      $today = date('Y-m-d');
      $diff =  - strtotime($date) - strtotime($today);
      $diffDate  = $diff / (60*60*24);
      return $diffDate;
    }

    public static function getOrderRate($order){
      $order_rate = OrderRate::find()->where(['order_id' => $order->order_id])
      ->andWhere(['flag' => '1'])->one();
      return $order_rate;
    }

    public static function getTotalTaxPaid($order){
      $amount = Payment::find()->where(['order_id' => $order->order_id])
      ->sum('tax');
      return $amount;
    }

    public static function getTotalTax($order){
      $amount1 = Invoice::find()->where(['order_id' => $order->order_id])
      ->sum('prev_tax');
      $amount2 = Invoice::find()->where(['order_id' => $order->order_id])
      ->sum('current_tax');
      return $amount1 + $amount2;
    }

    public static function getTotalLeaseRent($order){
      $amount = Invoice::find()->where(['order_id' => $order->order_id])
      ->andWhere(['flag' => 1])
      ->sum('current_lease_rent');
      return $amount;
    }

    public static function getTotalPenal($order){
      $amount = Debit::find()->where(['order_id' => $order->order_id])
      ->sum('penal');
      return $amount;
    }

    public static function getTotalLeaseRentPaid($order){
      $amount = Payment::find()->where(['order_id' => $order->order_id])
      ->sum('lease_rent');
      return $amount;
    }

    public static function getTotalPenalPaid($order){
      $amount = Payment::find()->where(['order_id' => $order->order_id])
      ->sum('penal');
      return $amount;
    }

    public static function getTotalAmount($order){
      $invoice = Invoice::find()->where(['order_id' => $order->order_id])
      ->orderBy(['invoice_id' => SORT_DESC])->one();
      return $invoice->total_amount;
    }

    public static function getTotalAmountPaid($order){
      $amount = Payment::find()->where(['order_id' => $order->order_id])
      ->sum('amount');
      return $amount;
    }

  

    public static function calculateBalancePenalAmount($order){
      $totalPenal = MyInvoice::getTotalPenal($order);
      $totalPenalPaid = MyInvoice::getTotalPenalPaid($order);
      $balancePenal = $totalPenal - $totalPenalPaid;
      return $balancePenal;
    }

    public static function calculatePenalInterest($order,$prevInvoice,$interest){
      $totalLeaseRent = MyInvoice::getTotalLeaseRent($order);
      $totalLeaseRentPaid = MyInvoice::getTotalLeaseRentPaid($order);
      $balanceLeaseRent = $totalLeaseRent - $totalLeaseRentPaid;
      $penalAmount = 0;
      // Penal intrest needs to be paid
      if($balanceLeaseRent != 0){
        $diffDate = MyInvoice::getDateDifference($prevInvoice->due_date);
        if($diffDate > 0){
          $penalAmount = (($diffDate  * ($interest->rate)/100) * $balanceLeaseRent ) / 365;
          }
      }
      return $penalAmount;
    }

    public static function generateInvoice($order){
      date_default_timezone_set('Asia/Kolkata');
      $prevInvoice = Invoice::find()->where(['order_id' => $order->order_id])
      ->orderBy(['order_id' => SORT_DESC ])->one();

      $invoice = new Invoice();
      $order_rate = MyInvoice::getCurrentOrderRate($order);
      $tax = MyInvoice::getCurrentTax();
      $interest =  MyInvoice::getCurrentInterest();
      $area = $order->area;
      $areaCode = strtoupper(substr($area->name,0,3));

      $invoice->order_id = $order->order_id;
      $invoice->tax_id = $tax->tax_id;
      $invoice->interest_id = $interest->interest_id;
      // First Inovice
      if(!$prevInvoice){
        $invoice->prev_lease_rent = 0;
        $invoice->start_date = date('Y-m-d');
        $invoice->prev_tax = 0;
        $invoice->prev_interest = 0;
        $invoice->prev_dues_total = 0;
        $invoice->current_lease_rent = $order_rate->amount1;
        $order_rate = MyInvoice::getOrderRate($order);
        $diffDate = MyInvoice::getDateDifference($order_rate->end_date);
        if($diffDate >= 0){ // NEED TO ADD AMOUNT2
          $invoice->current_lease_rent = $order_rate->amount1 + $order_rate->amount2;
        }
        $invoice->current_tax = ($tax->rate/100) * $invoice->current_lease_rent;
        $invoice->current_dues_total = $invoice->current_tax + $invoice->current_lease_rent;
        $invoice->due_date = date('Y-m-d', strtotime($order->start_date. ''));
        $invoice->lease_current_start = $invoice->due_date;
        $invoice->lease_prev_start = $invoice->due_date;
        $invoice->total_amount = $invoice->current_dues_total;
        $invoice->flag = '1';
        $invoice->invoice_code = MyInvoice::generateInvoiceCode($areaCode);
        $invoice->email_status = '0';
        // CG EMAIL
        $invoice->save();
      }else{
        $invoice->prev_lease_rent = $prevInvoice->current_lease_rent;
        $invoice->start_date = date('Y-m-d');
        $invoice->prev_tax = $prevInvoice->current_tax;
        $penalAmount = MyInvoice::calculatePenalInterest($order,$prevInvoice,$interest);
        $balancePenal = MyInvoice::calculateBalancePenalAmount($order);
        $invoice->prev_interest = round($penalAmount+$balancePenal);
        $totalAmount = MyInvoice::getTotalAmount($order);
        $totalAmountPaid = MyInvoice::getTotalAmountPaid($order);
        $due = $totalAmount - $totalAmountPaid;
        $invoice->prev_dues_total = $due + $invoice->prev_interest;
        $invoice->current_lease_rent = $order_rate->amount1;
        $order_rate = MyInvoice::getOrderRate($order);
        $diffDate = MyInvoice::getDateDifference($order_rate->end_date);
        if($diffDate >= 0){ // NEED TO ADD AMOUNT2
          $invoice->current_lease_rent = $order_rate->amount1 + $order_rate->amount2;
        }
        $invoice->current_tax = ($tax->rate/100) * $invoice->current_lease_rent;
        $invoice->current_dues_total = $invoice->current_tax + $invoice->current_lease_rent;
        $invoice->due_date = date('Y-m-d', strtotime($prevInvoice->due_date. ' + 1 year'));
        $invoice->lease_current_start = $invoice->due_date;
        $invoice->lease_prev_start = $prevInvoice->due_date;
        $invoice->total_amount = $invoice->current_dues_total + $invoice->prev_dues_total;
        $invoice->flag = '1';
        $invoice->invoice_code = MyInvoice::generateInvoiceCode($areaCode);
        $invoice->email_status = '0';
        // CG EMAIL
        $invoice->save();
        //Generate Debit Note
        if($penalAmount > 0){
          $debit = new Debit();
          $debit->penal = round($penalAmount);
          $debit->invoice_id = $invoice->invoice_id;
          $debit->order_id = $order->order_id;
          $debit->save(False);
        }
      }
      return $invoice;
    }

    public static function getCurrentOrderRate($order){
      $order_rate = OrderRate::find()
      ->where(['order_id' => $order->order_id ])
      ->andWhere(['flag' => 1])
      ->one();

      return $order_rate;
    }

    public static function getCurrentTax(){
      $tax = Tax::find()
      ->where(['flag' => 1])
      ->one();
      return $tax;
    }

    public static function getCurrentInterest(){
      $interest = Interest::find()
      ->where(['name' => 'Penal Interest'])
      ->andWhere(['flag' => 1])
      ->one();

      return $interest;
    }


 //    public function generate($invoice){
 //      date_default_timezone_set('Asia/Kolkata');
 //
 //      $order_id = $invoice->order->order_id;
 //
 //      $order_rate = OrderRate::find()
 //      ->where(['order_id' => $order_id ])
 //      ->andWhere(['flag' => 1])
 //      ->one();
 //
 //      $tax = Tax::find()
 //      ->where(['flag' => 1])
 //      ->one();
 //
 //      $interest = Interest::find()
 //      ->where(['name' => 'Penal Interest'])
 //      ->andWhere(['flag' => 1])
 //      ->one();
 //
 //      $totalPaid = Payment::find()
 //      ->where(['invoice_id' => $invoice->invoice_id])
 //      ->andWhere(['status' => 1])
 //      ->sum('amount');
 //
 //      $totalPenalPaid = Payment::find()
 //      ->where(['invoice_id' => $invoice->invoice_id])
 //      ->andWhere(['status' => 1])
 //      ->sum('penal');
 //
 //      $totalPenal = Debit::find()
 //      ->where(['invoice_id' => $invoice->invoice_id])
 //      ->sum('penal');
 //
 //      $this->$prev_interest = $totalPenal;
 //
 //      $this->prev_dues_total = $invoice->grand_total - $totalPaid;
 //      $this->order_id = $order_id;
 //      $this->tax_id = $tax->tax_id;
 //      $this->interest_id = $interest->interest_id;
 //
 //      $this->current_lease_rent = $order_rate->amount1;
 //      $this->current_tax = $this->current_lease_rent * ($tax->rate/100);
 //      $this->current_total_dues = $this->current_lease_rent + $this->current_tax;
 //
 //      $this->prev_dues_total = $invoice->grand_total - $totalPaid;
 //      $this->grand_total = $this->prev_dues_total + $this->current_total_dues;
 //
 //      $start_date = $invoice->start_date;
 //      $this->start_date = $start_date;
 //
 //      if($start_date > $order_rate->end_date ){
 //       $this->current_lease_rent = $this->current_lease_rent + $order_rate->amount1;
 //      }
 //
 //      $this->prev_lease_rent = $invoice->current_lease_rent;
 //      $this->prev_tax = $invoice->current_tax;
 //
 //      $invoiceDueDate = date('d-m-Y', strtotime($invoice->due_date. ' + 1 year '));
 //      $this->due_date = $invoiceDueDate;
 //
 //      $invoiceCode = '';
 //      $order =  Orders::findOne($order_id);
 //      $time = strtotime($order->start_date);
 //      $area = $invoice->order->area;
 //      $areaCode = strtoupper(substr($area->name,0,3));
 //      $invoiceCode = $areaCode .'/';
 //
 //      $year = date('Y');
 //      $year = substr($year,2,3);
 //      $invoiceCode = $areaCode . '/' . $year;
 //      $year = intval($year) + 1;
 //      $invoiceCode = $invoiceCode . '-' . $year;
 //      $this->invoice_code = 'hello';
 //      $this->save(False);
 //      $invoiceID = strval($this->invoice_id);
 //      $len = strlen($invoiceID);
 //      for ($i=0; $i < (4 - $len); $i++) {
 //        $invoiceID = '0'. $invoiceID;
 //      }
 //      $invoiceCode = $invoiceCode . '/' . $invoiceID;
 //      $this->invoice_code = $invoiceCode;
 //      $this->save(False);
 //      //http://localhost/gidc/web/index.php?r=invoice%2Fview&id=2 send email
 //      Yii::$app->mailer->compose()
 //            ->setFrom('castorgodinho22@gmail.com')
 //            ->setTo($this->order->company->user->email)
 //            ->setSubject('Test Email')
 //            ->setTextBody('Body Text')
 //            ->send();
 // }


}
