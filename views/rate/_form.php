<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Rate */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\ArrayHelper;
use app\models\Area;
$area = Area::find()->all();

?>

<div class="rate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'area_id')->dropDownList(ArrayHelper::map($area, 'area_id', 'name')); ?>

    <?= $form->field($model, 'extra')->textInput() ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
