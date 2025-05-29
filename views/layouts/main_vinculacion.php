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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
    <script src="<?= Yii::$app->request->baseUrl ?>/js/script_alumno.js" defer></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="main-container">
    <div class="navbar">
        <div class="titulo"><h2>Vinculacion</h2><span class="material-symbols-outlined">menu</span></div>
        <ul>
            <li><a href="<?= Url::to(['/vinculacion']) ?>">Inicio</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Prácticas</a>
                <ul class="submenu">
                    <li><a href="<?= Url::to(['vinculacion/datos']) ?>">Hojas de Datos</a></li>
                    <li><a href="<?= Url::to(['vinculacion/aceptacion']) ?>">Cartas de Aceptacion</a></li>
                    <li><a href="<?= Url::to(['vinculacion/presentacion']) ?>">Cartas de Presentación</a></li>
                    <li><a href="<?= Url::to(['vinculacion/terminacion']) ?>">Cartas Término</a></li>
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
