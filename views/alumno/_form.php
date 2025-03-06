<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alumno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id_semestreactual')->textInput() ?>
    <?= $form->field($model, 'id_institucion')->textInput() ?>
    <?= $form->field($model, 'nss')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino']) ?>
    <?= $form->field($model, 'id_grado')->textInput() ?>
    <?= $form->field($model, 'id_grupo')->textInput() ?>
    <?= $form->field($model, 'id_carrera')->textInput() ?>
    <?= $form->field($model, 'id_turno')->textInput() ?>
    <?= $form->field($model, 'telefono_uno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telefono_dos')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'calle')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'colonia')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'municipio')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id_ciclo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
