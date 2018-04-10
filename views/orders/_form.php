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
    
    <button type="button" class="add-plot-btn btn btn-default">ADD + </button>
    <div class="plots">
        <hr>
        <div class="plot">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="button" class="close-plot btn btn-default">x</button>
                </div>
            </div>
            
            
            <?= $form->field($model, 'plot_id[]')->dropDownList(ArrayHelper::map($plot, 'plot_id', 'name')); ?>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'built_area[]')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'shed_area[]')->textInput() ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'godown_area[]')->textInput() ?>
                </div>
            </div>
            <hr>
        </div>
    </div>
    
    

    
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