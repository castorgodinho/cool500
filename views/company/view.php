<?php

use yii\helpers\Html;
use app\models\Orders;
use app\models\OrderDetails;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

?>

<div class="panel panel-default">
  <div class="panel-heading">Unit Details</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-4">
        <p> <strong>Company Name </strong> <?= $model->name ?></p>
        <p></p>
      </div>
      <div class="col-md-4">
        <p> <strong>GSTIN  </strong> <?= $model->gstin ?></p>
        <p></p>
      </div>
      <div class="col-md-4">
        <p> <strong>Constitution.</strong> <?= $model->constitution ?></p>
        <h4></h4>
      </div>
    </div> 
    <div class="row">
      <div class="col-md-4">
        <p> <strong>Products </strong> <?= $model->products ?></p>
        <p></p>
      </div>
    </div> 
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Contact Details</div>
  <div class="panel-body">
  <div class="row">
  <div class="col-md-3">
    <p> <strong>Company Owner </strong> <?= $model->owner_name ?></p>
    <p></p>
  </div>
  <div class="col-md-3">
    <p> <strong>Phone No.  </strong> <?= $model->owner_phone ?></p>
    <p></p>
  </div>
  <div class="col-md-3">
    <p> <strong>Mobile No.</strong> <?= $model->owner_mobile ?></p>
    <h4></h4>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <p> <strong>Email </strong> <?= $model->user->email ?></p>
    <h4></h4>
  </div>
  <div class="col-md-3">
    <p> <strong>Competent Person</strong> <?= $model->competent_name ?></p>
    <h4></h4>
  </div>
  <div class="col-md-3">
    <p> <strong>Competent Person Mobile No</strong> <?= $model->competent_mobile ?></p>
    <h4></h4>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <p><strong>Competent Email </strong> <?= $model->competent_email ?></p>
    <h4></h4>
  </div>
  <div class="col-md-3">
    <p><strong>Address</strong> <?= $model->address ?></p>
    <h4></h4>
  </div>
</div>
  </div>
</div>


<div class="order-info">
  <?php 
    if(is_array($orders)){
      foreach($orders as $order){
  ?>
    <div class="panel panel-default">
      <div class="panel-heading">Order Number: <?= $order->order_number ?></div>
      <div class="panel-body">
      <?php 
        $plots = OrderDetails::find()->where(['order_id' => $order->order_id]);
        $dataProvider = new ActiveDataProvider([
          'query' => $plots,
        ]);
      ?>
      <p><b>Date of allotment: </b><?= $order->start_date ?></p><br>
      <p><b>Company: </b><?= $order->company_id ?></p><br>
      <p><b>Industrial Area: </b><?= $order->area_id ?></p><br>
      <p><b>Built Area: </b><?= $order->built_area ?></p><br>
      <p><b>Shed Area: </b><?= $order->shed_area ?></p><br>
      <p><b>Shed Number: </b><?= $order->shed_no ?></p><br>
      <p><b>Godown Area: </b><?= $order->godown_area ?></p><br>
      <p><b>Godown Number: </b><?= $order->godown_no ?></p><br>
      <p><b>Total Area: </b><?= $order->total_area ?></p><br>
      


      <h3>Plots of the order</h3>
      <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'plot.name',
            ],
        ]); ?>
      </div>
    </div>    
  <?php } }else{ ?>
    <div class="panel panel-default">
      <div class="panel-heading">Order Number: <?= $orders->order_number ?></div>
      <div class="panel-body">
        Panel content
      </div>
    </div> 
  <?php } ?>
  
</div>


<?php 

    $script = <<< JS
      $(document).ready(function(){
        /* $('.panel-body').hide(); */
        $('.panel-heading').click(function(){
          console.log("clik=cl");
          $(this).next().slideToggle();
        });

      });
JS;

    $this->registerJS($script);
?>