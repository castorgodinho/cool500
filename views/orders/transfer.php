<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">
    <h1>Tranfer Unit</h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
        echo $form->field($model, 'company_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($company, 'company_id', 'name'),
            'language' => 'de',
            'options' => ['placeholder' => 'Company'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>
    <?php 
        echo $form->field($model, 'area_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($area, 'area_id', 'name'),
            'language' => 'de',
            'options' => ['placeholder' => 'Industrial Estate'],
            'pluginOptions' => [
                'allowClear' => true,
                'disabled' => true
            ],
        ]);
    ?>
    <?= $form->field($model, 'transfer_file')->fileInput()->label("Transfer Document"); ?>
    <?= $form->field($model, 'total_area')->textInput(); ?>
    <?= $form->field($model, 'plots')->textInput(); ?>  

    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>

    <?= $form->field($model, 'end_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?>
    <?= $form->field($model, 'remark')->textarea(['maxlength' => true]) ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <hr>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($orderRate, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
                'options' => [
                'class' => 'form-control'
                ],
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($orderRate, 'end_date')->widget(\yii\jui\DatePicker::classname(), [
                'options' => [
                'class' => 'form-control'
                ],
                'language' => 'en',
                'dateFormat' => 'yyyy-MM-dd',
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($orderRate, 'amount1')->textInput()->label('Lease Rent',['class'=>'label-class']); ?>    
        </div>
        <div class="col-md-3">
            <?= $form->field($orderRate, 'amount2')->textInput()->label('Increment',['class'=>'label-class']); ?>  
        </div>
    </div>

    <select name="" id="input${1/(\w+)/\u\1/g}" class="form-control area-dropdown" required="required">
        <option value="" selected disabled hidden>Choose Area</option>
        <option value="built">Built</option>
        <option value="shed">Shed</option>
        <option value="godown">Godown</option>
    </select>
    <br>

    <div class="built hide-div">
        <?= $form->field($model, 'built_area')->textInput() ?>
    </div>
    <div class="shed hide-div">
        <?= $form->field($model, 'shed_area')->textInput() ?>
        <?= $form->field($model, 'shed_no')->textInput() ?>
    </div>
    <div class="godown hide-div">
        <?= $form->field($model, 'godown_area')->textInput() ?>
        <?= $form->field($model, 'godown_no')->textInput() ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Transfer', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


    $script = <<< JS
        var noOfDiv = 1;
        $(document).ready(function(){
            $('.hide-div').hide();
            $('.plot-div').hide();
            if($("#orders-built_area").val() != ""){
                $('.area-dropdown').val('built');
                $('.hide-div').hide();
                $('.built').show();
            }else if($("#orders-shed_area").val() != "" || $("#orders-shed_no").val() != ""){
                $('.area-dropdown').val('shed');
                $('.hide-div').hide();
                $('.shed').show();
            }else if($("#orders-godown_areaa").val() != "" || $("#orders-godown_no").val() != ""){
                $('.area-dropdown').val('godown');
                $('.hide-div').hide();
                $('.godown').show();
            }
            $('.area-dropdown').change(function(){
                $('.hide-div').hide();
                var className = $(this).val();
                $('.'+className).show();
            });
            $('.add').click(function(){
                $('.plots').append($('.plots').children().first().clone());
                noOfDiv++;
            });
            $('.sub').click(function(){
                if(noOfDiv > 1){
                    $('.plots').children().last().remove();
                    noOfDiv--;
                }

            });
        });

JS;

    $this->registerJS($script);
?>
