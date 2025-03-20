<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ingresa tu correo y contraseña para iniciar sesión:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['id' => 'email-input', 'autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput(['id' => 'password-input']) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Login', [
                        'class' => 'btn btn-warning',
                        'name' => 'login-button',
                        'id' => 'login-button'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div id="error-message" style="color: red; display: none;">
    El dominio del correo no es válido. Solo se permiten correos con dominio @cbt2metepec.edu.mx.
</div>

<script>
document.getElementById("login-button").addEventListener("click", function(event) {
    event.preventDefault(); // Evitar envío inmediato del formulario

    let email = document.getElementById("email-input").value;
    
    //REGRESAR ESTO A @ NMMMMMMMMMMMMMMMMMMMMMMMMSSSSSSS
    //@cbt2metepec.edu.mx
    if (email.endsWith("@")) { // Verifica si el correo es del dominio permitido
        window.location.href = "<?= yii\helpers\Url::to(['site/auth', 'authclient' => 'google']) ?>";
    } else {
        // Mostrar un mensaje de error
        document.getElementById("error-message").style.display = 'block';
        
        // Evitar el envío del formulario
        return false;
    }
});
</script>
