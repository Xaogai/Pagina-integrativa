<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<h2>Validar Carta de Aceptación</h2>

<iframe src="<?= Url::to(['/cartas-vinc/aceptacion', 'id' => $idUsuario]) ?>" width="100%" height="600px"></iframe>
<div style="margin-top:20px;">
    <?php if (Permisos::puedeEditar()): ?>
        <?php $form = ActiveForm::begin([
            'action' => ['cartas-vinc/aceptar-aceptacion'],
            'method' => 'post'
        ]); ?>
        <?= Html::hiddenInput('id', $idUsuario) ?>
        <?= Html::submitButton('Aceptar', [
            'class' => 'btn btn-success',
            'disabled' => !Permisos::puedeEditar() // Opcional: deshabilita en lugar de ocultar
        ]) ?>
        <?php ActiveForm::end(); ?>

        <button 
            class="btn btn-danger" 
            onclick="document.getElementById('form-rechazo').style.display='block'; this.style.display='none';"
            <?= !Permisos::puedeEditar() ? 'disabled' : '' ?>
        >
            Rechazar
        </button>
    <?php endif; ?>

    <?php if (Permisos::puedeEditar()): ?>
        <div id="form-rechazo" style="display:none; margin-top:10px;">
            <?php $form = ActiveForm::begin([
                'action' => ['vinculacion/cartas-vinc/rechazar-aceptacion'],
                'method' => 'post'
            ]); ?>
            <?= Html::hiddenInput('id', $idUsuario) ?>
            <?= $form->field($modelCartaAceptacion, 'comentario_vinculacion')->textarea([
                'name' => 'comentario',
                'required' => true
            ])->label('Motivo de rechazo') ?>
            <?= Html::submitButton('Enviar Rechazo', [
                'class' => 'btn btn-warning',
                'disabled' => !Permisos::puedeEditar()
            ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>
