<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\components\Permisos;
?>

<h2>Validar Carta de Presentación</h2>

<iframe src="<?= Url::to(['/cartas-vinc/presentacion', 'id' => $idUsuario]) ?>" width="100%" height="600px"></iframe>

<div style="margin-top:20px;">
    <?php $form = ActiveForm::begin([
        'action' => ['vinculacion/cartas-vinc/aceptar-presentacion'],
        'method' => 'post'
    ]); ?>
    <?= Html::hiddenInput('id', $idUsuario) ?>
    <?= Html::submitButton('Aceptar', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

    <button class="btn btn-danger" onclick="document.getElementById('form-rechazo').style.display='block'; this.style.display='none';">Rechazar</button>

    <div id="form-rechazo" style="display:none; margin-top:10px;">
        <?php $form = ActiveForm::begin([
            'action' => ['vinculacion/cartas-vinc/rechazar-presentacion'],
            'method' => 'post'
        ]); ?>
        <?= Html::hiddenInput('id', $idUsuario) ?>
        <?php 
        // Verificar si la variable está definida, si no, crear nueva instancia
        $model = isset($modelCartapresentacion) ? $modelCartapresentacion : new \app\models\CartaPresentacion();
        ?>
        <?= $form->field($model, 'comentario_vinculacion')->textarea([
            'name' => 'comentario',
            'required' => true
        ])->label('Motivo de rechazo') ?>
        <?= Html::submitButton('Enviar Rechazo', ['class' => 'btn btn-warning']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>