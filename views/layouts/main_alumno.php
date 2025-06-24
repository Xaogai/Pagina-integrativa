<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->beginPage();
?>

<?php
use app\models\Alumnos;
use app\models\HojaDatos;
use app\models\CartaAceptacion;
use app\models\CartaPresentacion;

$idUsuario = Yii::$app->session->get('user_id');

// Buscar al alumno
$alumno = Alumnos::find()->where(['id_usuario' => $idUsuario])->one();
$alumnoExiste = $alumno !== null;

// Verificar si tiene una hoja de datos aceptada
$hojaDatosAceptada = false;
if ($alumnoExiste) {
    $hojaDatosAceptada = HojaDatos::find()
        ->where(['id_alumno' => $alumno->id_alumno, 'status' => HojaDatos::STATUS_ACEPTADO])
        ->exists();
}

$cartaAceptacionAceptada = false;
if ($alumnoExiste) {
    $cartaAceptacionAceptada = CartaAceptacion::find()
        ->where(['id_alumno' => $alumno->id_alumno, 'status' => CartaAceptacion::STATUS_ACEPTADO])
        ->exists();
}

$cartaPresentacionAceptada = false;

if ($alumnoExiste) {
    $cartaPresentacionAceptada = CartaPresentacion::find()
        ->where(['id_alumno' => $alumno->id_alumno,'status' => CartaPresentacion::STATUS_ACEPTADO])
        ->exists();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/estilos_alumno.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
    <script src="<?= Yii::$app->request->baseUrl ?>/js/script_alumno.js" defer></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="main-container">
    <div class="navbar">
        <div class="titulo"><h2>Alumno</h2><span class="material-symbols-outlined">menu</span></div>
        <ul>
            <li><a href="<?= Url::to(['/alumno']) ?>">Inicio</a></li>
            <li><a href="<?= Url::to(['/alumno/alumno/datos-generales']) ?>">Datos del alumno</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn disabled">Prácticas</a>
                <ul class="submenu">
                    <?php if ($alumnoExiste): ?>
                        <li><a href="<?= Url::to(['empresa/datos-empresa']) ?>">Hoja de Datos</a></li>
                    <?php else: ?>
                        <li><a class="disabled-link">Hoja de Datos</a></li>
                    <?php endif; ?>
                    <?php if ($hojaDatosAceptada): ?>
                        <li><a href="<?= Url::to(['cartaaceptacion/datos-carta-aceptacion']) ?>">Carta de Aceptación</a></li>
                    <?php else: ?>
                        <li><a class="disabled-link">Carta de Aceptación</a></li>
                    <?php endif; ?>
                    <?php if ($cartaAceptacionAceptada): ?>
                        <li><a href="<?= Url::to(['carta-presentacion/datos-carta-presentacion']) ?>">Carta de Presentación</a></li>
                    <?php else: ?>
                        <li><a class="disabled-link">Carta de Presentación</a></li>
                    <?php endif; ?>
                    <?php if ($cartaPresentacionAceptada): ?>
                        <li><a href="<?= Url::to(['carta-termino/datos-carta-termino']) ?>">Carta de Término</a></li>
                    <?php else: ?>
                        <li><a class="disabled-link">Carta de Término</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            
            <li class="logout-button">
                <?= Html::a('Cerrar sesión', ['site/logout'], [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post'
                ]) ?>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <?= $content ?>
    </div>
</div>

<footer>
    © CBT No. 2, METEPEC 2025
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
