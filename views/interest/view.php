<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Interest */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Interests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interest-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'interest_id',
            'name',
            'type',
            'rate',
            'start_date',
        ],
    ]) ?>

</div>
