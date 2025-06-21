<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

// Registrar recursos
$this->registerCssFile('@web/css/formulario_alumno.css');
$this->registerCssFile('@web/css/mensajes.css');
$this->registerJsFile('https://kit.fontawesome.com/10b8e36e08.js', ['crossorigin' => 'anonymous']);
$this->registerJsFile('@web/js/custom-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/manipula-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);

// Incluir el componente de diálogo
echo $this->render('@app/components/dialog_box');
?>

<div class="titulo">
    <h1>Datos de la empresa</h1>
    <p>Ingresa los datos de tu empresa<br></p><br>
</div>

<div class="alumno-form">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-container',  'enctype' => 'multipart/form-data']]); ?>

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
        <?= $form->field($model, 'logo')->fileInput(['class' => 'form-input', 'disabled' => !$editable]) ?>
    </div>
 
    <div class="buttons-group">
        <?php if ($editable): ?>
            <?= Html::button('Aceptar', [
                'class' => 'btn btn-primary',
                'id' => 'btn-aceptar-dialog'
            ]) ?>
        <?php else: ?>
            <?= Html::button('Editar', ['class' => 'btn btn-secondary', 'id' => 'btn-editar']) ?>
        <?php endif;?>
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
            'Generar PDF',
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

    <?php ActiveForm::end(); ?>
    

    </div>
</div>
