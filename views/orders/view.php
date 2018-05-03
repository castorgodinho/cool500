<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\OrderRate;
use yii\data\ActiveDataProvider;


/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->title = "Orders";
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-view">

    <h1><?= Html::encode("Order Details") ?></h1>
    <br>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_number',
            'company.name',
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
            'amount1',
            'amount2',
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
