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
        <?= $form->field($model, 'jefe_inmediato')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'perfil_profesional')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'cargo')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'nombre_lugar')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'calle')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'colonia')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'municipio')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'telefono_uno')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'telefono_dos')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'rfc')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'correo')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'logo')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

 
    <div class="form-group">
        <?php if ($editable): ?>
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'accion', 'value' => 'aceptar']) ?>
        <?php else: ?>
            <?= Html::button('Editar', ['class' => 'btn btn-secondary', 'id' => 'btn-editar']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
        use app\models\HojaDatos;

        // Verifica si hay hoja de datos relacionada
        $idAlumno = Yii::$app->user->identity->id_alumno ?? null;
        $idEmpresa = $model->id_empresa ?? null;

        $hojaDatos = null;
        if ($idAlumno && $idEmpresa) {
            $hojaDatos = HojaDatos::find()
                ->where(['id_alumno' => $idAlumno, 'id_empresa' => $idEmpresa])
                ->one();
        }

        // Botón activo solo si hay hoja de datos y no está en modo edición
        $botonActivo = $hojaDatos && !$editable;

        echo Html::a(
            '📄 Generar PDF',
            ['practicas/datos'],
            [
                'class' => 'btn btn-primary mt-2' . ($botonActivo ? '' : ' disabled'),
                'title' => $botonActivo ? 'Generar PDF de Hoja de Datos' : 'Primero guarda la hoja de datos',
                'aria-disabled' => $botonActivo ? 'false' : 'true',
                'target' => '_blank'
            ]
        );
        ?>

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

