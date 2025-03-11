<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="alumno-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'correo')->input('email') ?>
    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nss')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino'], ['prompt' => 'Seleccione un género']) ?>
    
    <?= $form->field($model, 'id_semestreactual')->dropDownList($semestres, ['prompt' => 'Seleccione un semestre']) ?>
    <?= $form->field($model, 'id_institucion')->dropDownList($instituciones, ['prompt' => 'Seleccione una institución']) ?>
    <?= $form->field($model, 'id_grado')->dropDownList($grados, ['prompt' => 'Seleccione un grado']) ?>
    <?= $form->field($model, 'id_grupo')->dropDownList($grupos, ['prompt' => 'Seleccione un grupo']) ?>
    <?= $form->field($model, 'id_carrera')->dropDownList($carreras, ['prompt' => 'Seleccione una carrera']) ?>
    <?= $form->field($model, 'id_turno')->dropDownList($turnos, ['prompt' => 'Seleccione un turno']) ?>
    <?= $form->field($model, 'id_ciclo')->dropDownList($ciclos, ['prompt' => 'Seleccione un ciclo escolar']) ?>

    <?= $form->field($model, 'telefono_uno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono_dos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'calle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'colonia')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'municipio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
