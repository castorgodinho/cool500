<?php

use yii\helpers\Html;
use app\models\Orders;
use app\models\Invoice;
use app\models\Payment;
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
        <p> <strong>GSTIN  </strong> <?= $model->gstin ?> <a href="index.php?r=company/update-gst&id=<?= $model->company_id ?>" >Edit</a></p>
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
      <div class="col-md-4">


            <?php
              if($model->url != ''){
                echo "<a href='$model->url'>Download GSTIN file</a>";
              }
            ?>

      </div>
      <div class="col-md-4">

            <?php
              if($model->remark_url != ''){
                echo "<a href='$model->remark_url'>Download Remark</a>";
              }
            ?>

      </div>
    </div>
    <div class="row">
      <div class="col-md-4">

            <?php
              if($model->tds_url != ''){
                echo "<p><a href='$model->tds_url'>Download TDS Document</a></p>";
              }
            ?>

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
  <div class="col-md-3">
    <p><strong>Remark</strong> <?= $model->remark ?></p>
    <h4></h4>
  </div>.
</div>
  </div>
</div>


<div class="order-info">
  <?php
    if(is_array($orders)){
      foreach($orders as $order){
  ?>
    <div class="panel panel-default">
      <div class="panel-heading">

      <div class="row">
        <div class="col-md-6">
        <b> Plots:</b> <?= $order->plots; ?>
        <?php if ($order->shed_no != ""){ ?><b>Shed Number: </b><?= $order->shed_no ?><?php } ?>
          <?php if ($order->godown_no != ""){ ?><b>Godown Number: </b><?= $order->godown_no ?><?php } ?>
        </div>
        <div class="col-md-6">
          <div class="text-right">
           
            <b> Unit No:</b>  <?= $order->order_number ?> </p>
          </div>
        </div>
      </div>



       </div>
      <div class="panel-body-order panel-body">

      <div class="row">
        <div class="col-md-4">
          <p><b>Date of allotment: </b><?= $order->start_date ?></p><br>
          <p><b>Company: </b><?= $order->company->name ?></p><br>
          <p><b>Industrial Area: </b><?= $order->area->name ?></p><br>
          <p><?php if(Yii::$app->user->can('admin')){ ?>
            <a href="index.php?r=invoice%2Fgenerate&order_id=<?= $order->order_id; ?>" class="btn btn-success">Generate Invoice</a>
            <?php }?>
        </div>
        <div class="col-md-4">
          <p><b>Total Area: </b><?= $order->total_area ?></p><br>
          <?php if ($order->built_area != ""){ ?><p><b>Built Area: </b><?php  $order->built_area ?></p><?php } ?><br>
          <?php if ($order->shed_area != ""){ ?><p><b>Shed Area: </b><?= $order->shed_area ?></p><?php } ?><br>

        </div>
        <div class="col-md-4">
        <?php if ($order->godown_area != ""){ ?><p><b>Godown Area: </b><?= $order->godown_area ?></p><?php } ?><br>
        <?php if ($order->godown_no != ""){ ?><p><b>Godown Number: </b><?= $order->godown_no ?></p><?php } ?><br>
        <?php if ($order->shed_no != ""){ ?><p><b>Shed Number: </b><?= $order->shed_no ?></p> <?php } ?> <br>
        </div>
      </div>

      <h4><u>Invoices</u></h4>
      <?php
        $query = Invoice::find()->where(['order_id' => $order->order_id]);
        $provider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]);
      ?>
      <?=
        yii\grid\GridView::widget([
          'dataProvider' => $provider,
          'columns' => [
            'invoice_code',
            'grand_total',
            'start_date',
            [
              'class' => 'yii\grid\ActionColumn',
              'header' => 'Actions',
              'headerOptions' => ['style' => 'color:#337ab7'],
              'template' => '{view}',
              'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                },



              ],
              'urlCreator' => function ($action, $provider, $key, $index) {
                  if ($action === 'view') {
                      $url ='index.php?r=invoice%2Fview&id='.$provider['invoice_id'];
                      return $url;
                  }

                  }
          ],
          ]
      ]);

      ?>
      <h4><u>Payments</u></h4>
      <?php
        $query = Payment::find()->where(['order_id' => $order->order_id]);
        $provider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]);
      ?>
      <?=
        yii\grid\GridView::widget([
          'dataProvider' => $provider,
          'columns' => [
            'payment_id',
            'order_id',
            'amount',
            'start_date',
            'mode',
            'invoice.invoice_code',
            [
              'class' => 'yii\grid\ActionColumn',
              'header' => 'Actions',
              'headerOptions' => ['style' => 'color:#337ab7'],
              'template' => '{view}',
              'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                },



              ],
              'urlCreator' => function ($action, $provider, $key, $index) {
                  if ($action === 'view') {
                      $url ='index.php?r=payment%2Fview&id='.$provider['payment_id'];
                      return $url;
                  }

                  }
          ],
          ]
      ]);
      ?>



      </div>
    </div>
  <?php } }else{ ?>
    <div class="panel panel-default">
      <div class="panel-heading">Unit No: <?= $orders->order_number ?></div>
      <div class="panel-body">
        Panel content
      </div>
    </div>
  <?php } ?>

</div>


<?php

    $script = <<< JS
      $(document).ready(function(){

        $('.panel-body-order').hide();
        $('.panel-heading').click(function(){
          console.log("clik=cl");
          $(this).next().slideToggle();
        });

      });
JS;

    $this->registerJS($script);
?>
