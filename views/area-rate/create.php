<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AreaRate */

$this->title = 'Create Area Rate';
$this->params['breadcrumbs'][] = ['label' => 'Area Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
