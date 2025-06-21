<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
    }
    
    body {
        background-image: url('/img/cbt2Fondo.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-color: #f8f9fa; /* Color de respaldo por si la imagen no carga */
    }

    .login-container {
        display: flex;
        height: 100vh;
        background-color: rgba(255, 255, 255, 0.95); 
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        max-width: 900px;
        margin: auto;
    }

    .login-left {
        flex: 1;
        background-image: url('/img/cbt2logo.png'); 
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-left h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .login-right {
        flex: 1;
        background: white;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-control {
        border: none;
        border-bottom: 2px solid #444;
        border-radius: 0;
        margin-bottom: 1.5rem;
    }

    .btn-custom {
        background-color: #2d3e50;
        color: white;
        border-radius: 2rem;
        padding: 0.5rem 2rem;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #1b2838;
    }

    .text-small {
        font-size: 0.9rem;
        text-align: center;
    }
</style>

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px;">
    <div class="text-center">
        <!-- Logo centrado -->
        <img src="<?= Yii::getAlias('@web') ?>/img/cbt2logo.png" alt="Logo" style="width: 120px; margin-bottom: 20px;">

        <!-- Título -->
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Ingresa tu correo y contraseña para iniciar sesión:</p>

        <!-- Login Form -->
        <div class="mx-auto" style="max-width: 400px;">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label text-start'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'email')->textInput(['id' => 'email-input', 'autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['id' => 'password-input']) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-custom w-100',
                    'name' => 'login-button',
                    'id' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <!-- Mensaje de error personalizado -->
        <div id="error-message" style="color: red; display: none; margin-top: 15px;">
            El dominio del correo no es válido. Solo se permiten correos con dominio @cbt2metepec.edu.mx.
        </div>
    </div>
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