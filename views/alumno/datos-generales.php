<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// Vincular el archivo CSS específico del formulario sin dependencias
$this->registerCssFile('@web/css/formulario_alumno.css');
?>

<div class="alumno-form">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-container']]); ?>

    <div class="form-row">
        <?= $form->field($model, 'correo', ['options' => ['class' => 'form-group']])->input('email', ['class' => 'form-input']) ?>
        <?= $form->field($model, 'curp', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'nombre', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'apellido_paterno', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'apellido_materno', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_semestreactual', ['options' => ['class' => 'form-group']])->dropDownList($semestres, ['prompt' => 'Seleccione un semestre', 'class' => 'form-input']) ?>
        <?= $form->field($model, 'id_institucion', ['options' => ['class' => 'form-group']])->dropDownList($instituciones, ['prompt' => 'Seleccione una institución', 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'nss', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'fecha_nacimiento', ['options' => ['class' => 'form-group']])->input('date', ['class' => 'form-input']) ?>
        <?= $form->field($model, 'sexo', ['options' => ['class' => 'form-group']])->dropDownList(['F' => 'Femenino', 'M' => 'Masculino'], ['prompt' => 'Seleccione un género', 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_grado', ['options' => ['class' => 'form-group']])->dropDownList($grados, ['prompt' => 'Seleccione un grado', 'class' => 'form-input']) ?>
        <?= $form->field($model, 'id_grupo', ['options' => ['class' => 'form-group']])->dropDownList($grupos, ['prompt' => 'Seleccione un grupo', 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_carrera', ['options' => ['class' => 'form-group']])->dropDownList($carreras, ['prompt' => 'Seleccione una carrera', 'class' => 'form-input']) ?>
        <?= $form->field($model, 'id_turno', ['options' => ['class' => 'form-group']])->dropDownList($turnos, ['prompt' => 'Seleccione un turno', 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'telefono_uno', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'telefono_dos', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'calle', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'numero', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'colonia', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'codigo_postal', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'municipio', ['options' => ['class' => 'form-group']])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
        <?= $form->field($model, 'id_ciclo', ['options' => ['class' => 'form-group']])->dropDownList($ciclos, ['prompt' => 'Seleccione un ciclo escolar', 'class' => 'form-input']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>