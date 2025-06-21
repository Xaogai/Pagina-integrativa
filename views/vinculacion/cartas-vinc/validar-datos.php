<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\components\Permisos;
?>

<h2>Validar Hoja de Datos</h2>

<iframe src="<?= Url::to(['/cartas-vinc/datos', 'id' => $idUsuario]) ?>" width="100%" height="600px"></iframe>

<div style="margin-top:20px;">
    <?php $form = ActiveForm::begin([
        'action' => ['cartas-vinc/aceptar-datos'],
        'method' => 'post'
    ]); ?>
    <?= Html::hiddenInput('id', $idUsuario) ?>
    <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

    <button class="btn btn-danger" onclick="document.getElementById('form-rechazo').style.display='block'; this.style.display='none';">Rechazar</button>

    <div id="form-rechazo" style="display:none; margin-top:10px;">
        <?php $form = ActiveForm::begin([
            'action' => ['vinculacion/cartas-vinc/rechazar-datos'],
            'method' => 'post'
        ]); ?>
        <?= Html::hiddenInput('id', $idUsuario) ?>
        <?= $form->field($modelHojaDatos, 'comentario_vinculacion')->textarea([
            'name' => 'comentario',
            'required' => true
        ])->label('Motivo de rechazo') ?>
        <?= Html::submitButton('Enviar Rechazo', ['class' => 'btn btn-warning']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>