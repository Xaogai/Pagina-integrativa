<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="alumno-form">
    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_aceptacion')->input('date') ?>
    <?= $form->field($model, 'fecha_termino')->input('date') ?>
    

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
