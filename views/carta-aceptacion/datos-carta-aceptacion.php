<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Carta de Aceptación';
$this->params['breadcrumbs'][] = $this->title;

// Registrar recursos
$this->registerCssFile('@web/css/formulario_alumno.css');
$this->registerCssFile('@web/css/mensajes.css');
$this->registerJsFile('https://kit.fontawesome.com/10b8e36e08.js', ['crossorigin' => 'anonymous']);
$this->registerJsFile('@web/js/custom-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/manipula-dialog.js', ['depends' => [\yii\web\JqueryAsset::class]]);

// Incluir el componente de diálogo
echo $this->render('//components/dialog_box');?>

<div class="carta-aceptacion-form">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-container']]); ?>

    <?= Html::hiddenInput('editable', $editable ? '1' : '0', ['id' => 'editable-input']) ?>

    <div class="form-row">
        <?= $form->field($model, 'horario')->textInput([
            'maxlength' => true,
            'class' => 'form-input',
            'disabled' => !$editable,
            'placeholder' => 'Ej: Lunes a Viernes de 9:00 a 14:00'
        ]) ?>
        
        <?= $form->field($model, 'area')->textInput([
            'maxlength' => true,
            'class' => 'form-input',
            'disabled' => !$editable,
            'placeholder' => 'Ej: Departamento de Recursos Humanos'
        ]) ?>
    </div>

    <div class="form-row">
        <?= $form->field($model, 'fecha_inicio_servicio')->input('date', [
            'class' => 'form-input',
            'disabled' => !$editable
        ]) ?>
        
        <?= $form->field($model, 'fecha_termino_servicio')->input('date', [
            'class' => 'form-input',
            'disabled' => !$editable
        ]) ?>
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
            ['practicas/aceptacion'],
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
