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
    
    <div class="radio">
        <label>
            <input type="radio" name="area" class="shed-radio" id="" value="" checked="checked">
            Shed Area
        </label>
        <label>
            <input type="radio" name="area" class="built-radio" id="" value="" checked="checked">
            Built Area
        </label>
        <label>
            <input type="radio" name="area" class="godown-radio" id="" value="" checked="checked">
            Godown Area
        </label>
    </div>
    
    <div>
        <?= $form->field($model, 'built_area')->textInput() ?>
    </div>
    
    <?= $form->field($model, 'shed_area')->textInput() ?>
    <?= $form->field($model, 'godown_area')->textInput() ?>
    

    
    <?= $form->field($model, 'start_date')->widget(\yii\jui\DatePicker::classname(), [
        'options' => [
          'class' => 'form-control'
        ],
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
    ]) ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
    $script = <<< JS
        $(document).ready(function(){
            $('.add-plot-btn').click(function(){
                $('.plots').append($('.plot').clone());
            });

            $(".close-plot").on("click",function(){
                //console.log($(this).parents('.plot'));
                console.log("clicked..");
                //$(this).parents('.plot').hide();
            });
        });

JS;

    $this->registerJS($script);
?>