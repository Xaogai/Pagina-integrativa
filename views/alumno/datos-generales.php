<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// Registrar recursos
$this->registerCssFile('@web/css/formulario_alumno.css');
$this->registerCssFile('@web/css/mensajes.css');
$this->registerJsFile('https://kit.fontawesome.com/10b8e36e08.js', ['crossorigin' => 'anonymous']);
$this->registerJsFile('@web/js/custom-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/manipula-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);


// Incluir el componente de diálogo
echo $this->render('//components/dialog_box');
?>

<div class="titulo">
    <h1>Datos del Alumno</h1>
    <p>Ingresa tus datos alumno<br></p><br>
</div>

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
        <?= $form->field($model, 'correo')->input('email', ['class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'curp')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'id_semestreactual')->dropDownList($semestres, ['prompt' => 'Seleccione un semestre', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_institucion')->dropDownList($instituciones, ['prompt' => 'Seleccione una institución', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'nss')->textInput(['maxlength' => true, 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'fecha_nacimiento')->input('date', ['class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'otra_institucion')->dropDownList(['ISSEMYM' => 'ISSEMYM', 'ISSSTE' => 'ISSSTE'], ['prompt' => 'Seleccione otra institucion', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
    <?= $form->field($model, 'sexo')->dropDownList(['F' => 'Femenino', 'M' => 'Masculino'], ['prompt' => 'Seleccione sexo', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_grado')->dropDownList($grados, ['prompt' => 'Seleccione un grado', 'class' => 'form-input', 'disabled' => !$editable]) ?>
        <?= $form->field($model, 'id_grupo')->dropDownList($grupos, ['prompt' => 'Seleccione un grupo', 'class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>

    <div class="form-row">
    <?= $form->field($model, 'id_carrera')->dropDownList($carreras, ['prompt' => 'Seleccione una carrera', 'class' => 'form-input', 'disabled' => !$editable]) ?>
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
            <?= Html::button('Aceptar', [
                'class' => 'btn btn-primary',
                'id' => 'btn-aceptar-dialog'
            ]) ?>
        <?php else: ?>
            <?= Html::button('Editar', ['class' => 'btn btn-secondary', 'id' => 'btn-editar']) ?>
        <?php endif;?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS
$(document).ready(function() {
    var isEditable = $('#editable-input').val() === '1';

    if (isEditable) {
        function toggleInstituciones() {
            let nss = $('#alumnos-nss').val().trim();
            let otra = $('#alumnos-otra_institucion').val();

            if (nss !== '') {
                $('#alumnos-otra_institucion').prop('disabled', true).val('');
            } else if (otra !== '') {
                $('#alumnos-nss').prop('disabled', true).val('');
            } else {
                $('#alumnos-nss').prop('disabled', false);
                $('#alumnos-otra_institucion').prop('disabled', false);
            }
        }

        $('#alumnos-nss, #alumnos-otra_institucion').on('input change', toggleInstituciones);
        toggleInstituciones(); // ejecutar al cargar
    }
});
JS;

$this->registerJs($script);
?>