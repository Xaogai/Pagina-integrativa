<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alumno */

$this->title = 'Datos del alumno';
?>

<div>
    <h2>DATOS UWU ALUMNE</h2>
    <p>LLENE SUS DATES.</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sexo')->dropDownList(['M' => 'Masculino', 'F' => 'Femenino']) ?>
    <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
    <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nss')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>
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
