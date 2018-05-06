<?php

namespace app\models;
use app\models\Invoice;
use app\models\OrderRate;
use app\models\Payment;
use app\models\Interest;
use app\models\Tax;

use Yii;

class MyInvoice extends Invoice
{

    public static function createInvoices(){
      date_default_timezone_set('Asia/Kolkata');
      $date2 = date('Y-m-d');
      $invoices = Invoice::find()->all();
      foreach ($invoices as $invoice) {
        $date1 = date('Y-m-d', strtotime($invoice->start_date. ' + 15 days'));
        $diff = strtotime($date2) - strtotime($date1);
        $diffDate  = $diff / (60*60*24);
        if($diffDate == 0 ){
          $model = new MyInvoice();
          $model->generate($invoice);
        }
      }
    }

    public function generate($invoice){
      date_default_timezone_set('Asia/Kolkata');

      $order_id = $invoice->order->order_id;
      $order_rate = OrderRate::find()
      ->where(['order_id' => $order_id ])
      ->andWhere(['flag' => 1])
      ->one();

      $tax = Tax::find()
      ->where(['flag' => 1])
      ->one();

      $interest = Interest::find()
      ->where(['name' => 'Penal Interest'])
      ->andWhere(['flag' => 1])
      ->one();

      $totalPaid = Payment::find()
      ->where(['invoice_id' => $invoice->invoice_id])
      ->andWhere(['status' => 1])
      ->sum('amount');

      $totalPenal = Payment::find()
      ->where(['invoice_id' => $invoice->invoice_id])
      ->andWhere(['status' => 1])
      ->sum('penal');

      // TODO penal interest

      $this->prev_dues_total = $invoice->grand_total - $totalPaid;
      $this->order_id = $order_id;
      $this->tax_id = $tax->tax_id;
      $this->interest_id = $interest->interest_id;

       $this->current_lease_rent = $order_rate->amount1;
       $this->current_tax = $this->current_lease_rent * ($tax->rate/100);
       $this->current_total_dues = $this->current_lease_rent + $this->current_tax;

       $this->prev_dues_total = $invoice->grand_total -  $totalPaid;
       $this->grand_total = $this->prev_dues_total + $this->current_total_dues;

         $start_date = $invoice->start_date;
         $this->start_date = $start_date;

         if($start_date > $order_rate->end_date ){
          $this->current_lease_rent = $this->current_lease_rent + $order_rate->amount1;
         }

         $totalPaid = Payment::find()
         ->where(['invoice_id' => $invoice->invoice_id])
         ->andWhere(['status' => 1])
         ->sum('amount');

         $pi = Payment::find()
         ->where(['invoice_id' => $invoice->invoice_id])
         ->andWhere(['status' => 1])
         ->sum('penal');

         $this->prev_dues_total = $invoice->grand_total - $totalPaid + $pi;
         $this->prev_interest = $invoice->current_interest;

         $this->prev_lease_rent = $invoice->current_lease_rent;
         echo $invoice->prev_lease_rent.'<br>';
         $this->prev_tax = $invoice->current_tax;

         $this->current_total_dues = $this->current_lease_rent + $this->current_tax;

         $invoiceCode = '';
         $order =  Orders::findOne($order_id);
         $time = strtotime($order->start_date);
         $area = $invoice->order->area;
         $areaCode = strtoupper(substr($area->name,0,3));
         $invoiceCode = $areaCode .'/';

         $year = date('Y');
         $year = substr($year,2,3);
         $invoiceCode = $areaCode . '/' . $year;
         $year = intval($year) + 1;
         $invoiceCode = $invoiceCode . '-' . $year;
         $this->invoice_code = 'hello';
         $this->save(False);
         $invoiceID = strval($this->invoice_id);
         $len = strlen($invoiceID);
         for ($i=0; $i < (4 - $len); $i++) {
           $invoiceID = '0'. $invoiceID;
         }
         $invoiceCode = $invoiceCode . '/' . $invoiceID;
         $this->invoice_code = $invoiceCode;
         $this->save(False);
 }
}
