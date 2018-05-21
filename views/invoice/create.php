<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Rate;
use app\models\Tax;
use app\models\Interest;
use app\models\Orders;
use kartik\select2\Select2;

$tax = Tax::find()->all();
$interest = Interest::find()->all();
$order = Orders::find()->all();

?>
<div class="invoice-create">
  <center>
    <h2>Create Invoice</h2>
  </center>
  <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'tax_id')->dropDownList(ArrayHelper::map($tax, 'tax_id', 'rate')); ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'interest_id')->dropDownList(ArrayHelper::map($interest, 'interest_id', 'rate')); ?>
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
      <?= $form->field($model, 'due_date')->widget(\yii\jui\DatePicker::classname(), [
          'options' => [
            'class' => 'form-control'
          ],
          'language' => 'en',
          'dateFormat' => 'yyyy-MM-dd',
      ]) ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'prev_tax')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'prev_interest')->textInput() ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'prev_lease_rent')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'prev_dues_total')->textInput() ?>
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
      <?= $form->field($model, 'current_dues_total')->textInput() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'invoice_code')->textInput() ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
          <?= $form->field($model, 'lease_current_start')->widget(\yii\jui\DatePicker::classname(), [
              'options' => [
                'class' => 'form-control'
              ],
              'language' => 'en',
              'dateFormat' => 'yyyy-MM-dd',
          ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'lease_prev_start')->widget(\yii\jui\DatePicker::classname(), [
            'options' => [
              'class' => 'form-control'
            ],
            'language' => 'en',
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'total_amount')->textInput() ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'order_id')->dropDownList(ArrayHelper::map($order, 'order_id', 'order_number')); ?>
    </div>
  </div>



<center>
      <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</center>

  <?php ActiveForm::end(); ?>



</div>
