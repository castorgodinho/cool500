<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
    <?php if(Yii::$app->user->can('admin')){ ?>
    <div class="panel panel-default">
      <div class="panel-heading">Unit Information</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
          </div>
          <?php if($model->isNewRecord){ ?>
          <div class="col-md-6">
            <?= $form->field($model, 'gstin')->textInput(['maxlength' => true]) ?>
          </div>
          <?php } ?>
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
          <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">Contact Information</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <?= $form->field($user, 'email')->textInput() ?>
          </div>

          <div class="col-md-6">
          <?php if(Yii::$app->user->can('admin')){ ?>
            <?= $form->field($user, 'password')->passwordInput(); ?>
          <?php }else{ ?>
            <?= $form->field($user, 'password')->hiddenInput()->label(''); ?>
          <?php } ?>
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
            <?= $form->field($user, 'mobile')->textInput(['maxlength' => true]) ?>
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
          <div class="col-md-6">
          <?php if(Yii::$app->user->can('admin')){ ?>
            <?= $form->field($model, 'remark')->textarea(['maxlength' => true]) ?>
            <?= $form->field($model, 'file')->fileInput() ?>
          <?php } ?>
          </div>
          
        </div>

      </div>

    </div>

   
    
    </div>

    <div class="row">
      <center>  <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        </div>
      </center>

    </div>


    <?php ActiveForm::end(); ?>

</div>
