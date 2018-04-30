<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AreaRate;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchArea */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Industrial Estate';
?>
<div class="area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Industrial Estate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'total_area',
            [
                'label' => 'Rate',
                'value' => function ($dataProvider) {
                     return  AreaRate::find()->orderBy('start_date DESC')->one()->area_rate;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
