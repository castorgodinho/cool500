<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'order_number')->textInput() ?>
    <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map($company, 'company_id', 'name')); ?>
    <?= $form->field($model, 'area_id')->dropDownList(ArrayHelper::map($area, 'area_id', 'name')); ?>
    <button type="button" class="add" class="form-control" style="margin: 5px;">+</button>
    <button type="button" class="sub" class="form-control" style="margin: 5px;">-</button>
    <div class="row plots">
        <div class="col-md-1 plot-input">
            <?= $form->field($orderDetails, 'plot_id[]')->textInput() ?>
        </div>
    </div>
    
    
    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?> 
    
    <select name="" id="input${1/(\w+)/\u\1/g}" class="form-control" required="required">
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
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 


    $script = <<< JS
        var noOfDiv = 1;
        $(document).ready(function(){
            $('.hide-div').hide();
            $('.plot-div').hide();
            $('select').change(function(){
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