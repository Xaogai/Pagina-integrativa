<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\HojaDatos;

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

    <?php
    // Verifica si hay hoja de datos relacionada
    $idAlumno = Yii::$app->user->identity->id_alumno ?? null;
    $idEmpresa = $model->id_empresa ?? null;

    $hojaDatos = null;
    if ($idAlumno && $idEmpresa) {
        $hojaDatos = HojaDatos::find()
            ->where(['id_alumno' => $idAlumno, 'id_empresa' => $idEmpresa])
            ->one();
    }

    // Botón activo solo si hay hoja de datos y no es nuevo registro
    $botonActivo = $hojaDatos && !$model->isNewRecord;

    echo Html::a(
        '📄 Generar PDF',
        ['practicas/datos'],
        [
            'class' => 'btn btn-primary mt-2' . ($botonActivo ? '' : ' disabled'),
            'title' => $botonActivo ? 'Generar PDF de Hoja de Datos' : 'Primero debes guardar la hoja de datos',
            'aria-disabled' => $botonActivo ? 'false' : 'true',
            'target' => '_blank' // <- Esto abre el enlace en una nueva pestaña
        ]
    );    
    ?>
</div>
