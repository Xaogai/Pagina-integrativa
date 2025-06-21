<?php
use yii\helpers\Html;
use app\components\Permisos;
function traducirMes($fechaIngles) {
    $meses = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    ];
    
    foreach ($meses as $en => $es) {
        $fechaIngles = str_replace($en, $es, $fechaIngles);
    }
    return $fechaIngles;
}

function fechaTraducida($fecha, $formato = 'php:j \d\e F \d\e Y') {
    return traducirMes(Yii::$app->formatter->asDate($fecha, $formato));
}

?>
<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body>
        <header>
            <div class="asunto">
                <p>ASUNTO: CONSTANCIA DE COMPETENCIA LABORAL</p>
            </div>
            <div class="fecha-actual"><?= isset($carta['fecha_emision']) ? fechaTraducida($carta['fecha_emision']) : 'Fecha no disponible' ?>
            </div>
        </header>
        <main>
            <div class="presente">
                <p>MTRO. EN D. P. FRANCISCO RICARDO LÓPEZ SOTELO</p>
                <p>DIRECTOR ESCOLAR DEL CBT No. 2, METEPEC</p>
                <p>PRESENTE</p>
            </div>
            <div class="contenido">
                <p><strong>El que suscribe <p1 class="nombre-jefe"><?= Html::encode($carta['jefe_inmediato'] ?? 'No disponible') ?></p1></strong> se dirige a usted de la manera más atenta para hacer de su conocimiento que (el) la alumna (o); <p1 class="nombre-alumno"><?= Html::encode($carta['nombre_alumno'] . ' ' . $carta['apellido_paterno'] . ' ' . $carta['apellido_materno']) ?></p1> <strong>estudiante del <p1 class="semestre"><?= Html::encode($carta['semestre']['nombre'] ?? 'Semestre no disponible') ?></p1> semestre de la carrera <p1 class="carrera"><?= Html::encode($carta['carrera'] ?? 'Carrera no disponible') ?></p1>, turno <p1 class="turno"><?= Html::encode($carta['nombre_turno']?? 'Turno no disponible')?></p1>, CONCLUYÓ SUS PRÁCTICAS DE EJECUCIÓN DE COMPETENCIAS</strong> y se hace constar que cubrió con un total de 100 hrs., en formación de competencias laborales de manera eficiente, a partir del <p1 class="fecha-inicio"><?= isset($carta['fecha_aceptacion']) ? fechaTraducida($carta['fecha_aceptacion']) : 'Fecha no disponible' ?></p1> al <p1 class="fecha-final"><?= isset($carta['fecha_termino']) ? fechaTraducida($carta['fecha_termino']) : 'Fecha no disponible' ?></p1> en <p1 class="nombre-empresa"><?= Html::encode($carta['nombre_empresa'] ?? 'nombre_empresa no disponible') ?></p1>; manifiesto que el prestador (a) adquirió satisfactoriamente las competencias profesionales que marca el programa de estudio del módulo III; DEMUESTRA LAS HABILIDADES EN UN PUESTO LABORAL, DEL MODELO EDUCATIVO PARA LA EDUCACIÓN OBLIGATORIA (MEPEO, 2018) de la carrera técnica, las cuales son las siguientes;</p>
                <ul class="cualidades">
                <?php foreach ($carta['cualidades_separadas'] as $cualidad): ?>
                    <li><?= htmlspecialchars($cualidad) ?></li>
                <?php endforeach; ?>
                </ul>
                <p class="final">Sin otro particular por el momento, aprovecho la ocasión para enviarle un cordial saludo.</p>
            </div>
            <div class="firma">
                <p class="primero">ATENTAMENTE</p>
                <p><p1 class="cargo-jefe"><?= Html::encode($carta['cargo'] ?? 'Cargo no disponible') ?></p1> <p1 class="nombre-jefe"><?= Html::encode($carta['jefe_inmediato'] ?? 'No disponible') ?></p1></p>
                <p>NOMBRE Y FIRMA (SELLO) CARGO DEL JEFE INMEDIATO</p>
            </div>
        </main>
        <footer>
        </footer>
    </body>
</html>