<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\OrderRate;
use app\models\Orders;
use yii\data\ActiveDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = "Units";
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">
    <div class="row">
        <div class="col-md-6">
            <h1><?= Html::encode("Unit Details") ?></h1>
        </div>
        <div class="col-md-6 text-right">
            <?php if(Yii::$app->user->can('admin')){
                if($model->status == 1){
            ?>
                    <a href="index.php?r=orders/transfer&id=<?= $model->order_id ?> " class="btn btn-primary">Transfer Unit</a>
            <?php    
                }
            } 
            ?>
            
        </div>
    </div>
    
    <br>


    <?php 
        if($model->document){
            echo "<a href='". $model->document ."'>Download unit document</a>";
        }
    ?>
    <?php 
        if($model->status == 0){
            $transfer = Orders::findOne($model->next_order_id);
    ?>
            <div class="row" style="border: 1px solid black; padding: 20px;">
                <h3>Transfer Details</h3>
                <div class="col-md-6">
                    <p><b>Transfer Date: </b><?= $transfer->start_date; ?></p>
        <p> <?php if($transfer->transfer_url != null){?><a href="<?= $transfer->transfer_url; ?>">Download Transfer Document</a><?php } ?></p>
                </div>
                <div class="col-md-6">
                    <p><b>Transfered Company: </b><?= $transfer->company->name;?></p>
                </div>
            
            </div><br>
    <?php
       }
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_number',
            'company.name',
            'remark',
            'total_area',
            'start_date',
            'built_area',
            'shed_area',
            'plots',
            'shed_no',
            'godown_no',
            'godown_area',
            /* 'end_date', */
        ],
    ]) ?>

    <?php
        $query = OrderRate::find()->where(['order_id' => $model->order_id]);
        $provider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
              'pageSize' => 10,
          ],
      ]);
      ?>
    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'start_date',
            'end_date',
            [
                'label' => 'Lease Rent',
                'value' => 'amount1',
            ],
            [
                'label' => 'Increment',
                'value' => 'amount2',
            ],
            [
                'attribute' => 'flag',
                'value' => function($dataProvider){
                    if($dataProvider->flag == '1'){
                        return 'Current';
                    }else{
                        return 'Old';
                    }
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
