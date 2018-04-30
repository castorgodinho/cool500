<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchLog */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Email',
                'attribute' => 'user_id',
                'value' => 'user.email',
            ],
            [
                'label' => 'Role',
                'attribute' => 'user.type'
            ],
            [
                'label' => 'Type of log',
                'attribute' => 'type'
            ],
            [
                'label' => 'Created Date',
                'value' => function($dataProvider){
                    return date('F d Y h:m:s', strtotime($dataProvider->create_date));
                },
            ],
            [
                'label' => 'Updated Date',
                'value' => function($dataProvider){
                    return date('F d Y h:m:s', strtotime($dataProvider->updated_date));
                },
            ],
            

            /* 'create_date', */
            /* 'updated_date', */
            //'old_value:ntext',
            //'new_value:ntext',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php
    $script = <<< JS
    $( "a[aria-label='Update']" ).hide();
        $(document).ready(function(){

        });
JS;
    $this->registerJS($script);
?>
</div>
