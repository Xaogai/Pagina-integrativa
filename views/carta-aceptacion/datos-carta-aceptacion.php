<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Carta de Aceptación';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/formulario_alumno.css');
?>

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
        <?= $form->field($model, 'fecha_aceptacion')->input('date', [
            'class' => 'form-input',
            'disabled' => !$editable
        ]) ?>
        
        <?= $form->field($model, 'fecha_termino')->input('date', [
            'class' => 'form-input',
            'disabled' => !$editable
        ]) ?>
    </div>

    <div class="form-group">
        <?php if ($editable): ?>
            <?= Html::submitButton('Guardar Carta', [
                'class' => 'btn btn-primary',
                'name' => 'accion',
                'value' => 'aceptar'
            ]) ?>
        <?php else: ?>
            <?= Html::button('Editar', [
                'class' => 'btn btn-secondary',
                'id' => 'btn-editar'
            ]) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnEditar = document.getElementById('btn-editar');
    if (btnEditar) {
        btnEditar.addEventListener('click', function() {
            document.getElementById('editable-input').value = '1';
            document.forms[0].submit();
        });
    }
});
</script>