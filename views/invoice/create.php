<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Rate;
use app\models\Tax;
use app\models\Interest;

$rate = Rate::find()->all();
$tax = Tax::find()->all();
$interest = Interest::find()->all();

?>
<div class="invoice-create">
  <center>
    <h2>Create Invoice</h2>
  </center>
  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'rate_id')->dropDownList(ArrayHelper::map($rate, 'rate_id', 'rate')); ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'tax_id')->dropDownList(ArrayHelper::map($tax, 'tax_id', 'rate')); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
          'options' => [
            'class' => 'form-control'
          ],
          'language' => 'en',
          'dateFormat' => 'yyyy-MM-dd',
      ]) ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'order_id')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'interest_id')->dropDownList(ArrayHelper::map($interest, 'interest_id', 'rate')); ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'prev_tax')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'prev_interest')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'prev_lease_rent')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'prev_dues_total')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'current_interest')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'current_tax')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'current_lease_rent')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'current_total_dues')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'invoice_code')->textInput() ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'grand_total')->textInput() ?>
    </div>
    <div class="col-md-3">
    </div>
  </div>

<center>
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</center>

  <?php ActiveForm::end(); ?>



</div>
