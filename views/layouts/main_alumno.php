<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/css/estilos_alumno.css">
    <script src="<?= Yii::$app->request->baseUrl ?>/js/script_alumno.js" defer></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="main-container">
    <div class="navbar">
        <h2>Alumno</h2>
        <ul>
            <li><a href="<?= Url::to(['site/index']) ?>">Inicio</a></li>
            <li><a href="<?= Url::to(['/alumno/alumno/datos-generales']) ?>">Datos del alumno</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Prácticas</a>
                <ul class="submenu">
                    <li><a href="<?= Url::to(['empresa/datos-empresa']) ?>">Hoja de Datos</a></li>
                    <li><a href="<?= Url::to(['practicas/presentacion']) ?>">Carta de Presentación</a></li>
                    <li><a href="<?= Url::to(['practicas/terminacion']) ?>">Carta de Término</a></li>
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
        <h1>Panel del Alumno</h1>
        <?= $content ?>

        <div class="estado-estudiante">
            <h3>Estado del Estudiante</h3>
            <p id="estado"></p>
        </div>
    </div>
</div>

<footer>
    © CBT No. 2, METEPEC 2025
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
