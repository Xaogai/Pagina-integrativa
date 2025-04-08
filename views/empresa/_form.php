<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="alumno-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_empresa')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'jefe_inmediato')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'perfil_profesional')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre_lugar')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'calle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'colonia')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'municipio')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono_uno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono_dos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rfc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>
    

    
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
