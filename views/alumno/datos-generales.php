<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->registerCssFile('@web/css/formulario_alumno.css');
?>

<div class="alumno-form">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-container']]); ?>

    <!-- Campo oculto para determinar si estamos en modo edición -->
    <?= Html::hiddenInput('editable', $editable ? '1' : '0', ['id' => 'editable-input']) ?>

    <div class="form-row">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>
    
    <div class="form-row">
        <?= $form->field($model, 'curp')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'nss')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_semestreactual')->dropDownList($semestres, ['prompt' => 'Seleccione un semestre', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_institucion')->dropDownList($instituciones, ['prompt' => 'Seleccione una institución', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'fecha_nacimiento')->input('date', ['class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'sexo')->dropDownList(['F' => 'Femenino', 'M' => 'Masculino'], ['prompt' => 'Seleccione sexo', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_grado')->dropDownList($grados, ['prompt' => 'Seleccione un grado', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_grupo')->dropDownList($grupos, ['prompt' => 'Seleccione un grupo', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_carrera')->dropDownList($carreras, ['prompt' => 'Seleccione una carrera', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_turno')->dropDownList($turnos, ['prompt' => 'Seleccione un turno', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_ciclo')->dropDownList($ciclos, ['prompt' => 'Seleccione un ciclo', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'telefono_uno')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'telefono_dos')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'calle')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'colonia')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'municipio')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-group">
        <?php if ($editable): ?>
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'accion', 'value' => 'aceptar']) ?>
        <?php else: ?>
            <?= Html::button('Editar', ['class' => 'btn btn-secondary', 'id' => 'btn-editar']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEditar = document.getElementById('btn-editar');
        const editableInput = document.getElementById('editable-input');

        if (btnEditar) {
            btnEditar.addEventListener('click', function () {
                editableInput.value = '1'; // Cambiar el valor oculto
                document.forms[0].submit(); // Enviar el formulario para habilitar edición
            });
        }
    });
</script>
