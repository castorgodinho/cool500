<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
      <div class="panel-heading">Unit Information</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'gstin')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'constitution')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'products')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
      </div>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">Contact Information</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($user, 'email')->textInput() ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($user, 'password')->passwordInput() ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'owner_phone')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'owner_mobile')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'competent_name')->textInput(['maxlength' => true]) ?>
          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'competent_email')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'competent_mobile')->textInput(['maxlength' => true]) ?>
          </div>
          
        </div>

      </div>

    </div>

   
    
    </div>

    <div class="row">
      <center>  <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      </center>

    </div>


    <?php ActiveForm::end(); ?>

</div>
