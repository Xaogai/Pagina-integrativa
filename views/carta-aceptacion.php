<?php
use yii\helpers\Html; 

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
            <?php if ($cartas): ?> 
                <div style="text-align: center;">
                    <img src=<?= Html::encode($cartas[0]['logo'] ?? 'Logo no disponible') ?> style="width: 120px; height: auto;" alt="Logo">
                </div>
                <div class="asunto">
                    <p>ASUNTO: ACEPTACIÓN DE PRÁCTICAS<br>
                        DE EJECUCIÓN DE COMPETENCIAS</p>
                </div>
                <div class="fecha-actual">
                    San Bartolomé, Tlaltelulco, Metepec, Méx., a 
                    <?= isset($cartas[0]['fecha_emision']) ? 
                        traducirMes(Yii::$app->formatter->asDate($cartas[0]['fecha_emision'], 'php:j \d\e F \d\e Y')) : 
                        traducirMes(date('j \d\e F \d\e Y')) ?>
                </div>
            </header>
            <main>
                <div class="presente">
                    <p>MTRO. EN D. P. FRANCISCO RICARDO LÓPEZ SOTELO</p>
                    <p>DIRECTOR ESCOLAR DEL CBT No. 2, METEPEC</p>
                    <p>PRESENTE</p>
                </div>
                <div class="contenido">
                    <p>En atención a su oficio de presentación, me permito infórmale que el (la) alumno (a); 
                    <p1 class="nombre-alumno"><?= Html::encode(($cartas[0]['nombre_alumno'] ?? '') . ' ' . ($cartas[0]['apellido_paterno'] ?? '') . ' ' . ($cartas[0]['apellido_materno'] ?? '')) ?></p1> 
                    estudiante del <strong> <p1 class="semestre"><?= Html::encode($cartas[0]['semestre']['nombre'] ?? 'Semestre no disponible') ?></p1> SEMESTRE</strong> 
                    de la carrera <strong class="carrera"><?= Html::encode($cartas[0]['carrera'] ?? 'Carrera no disponible') ?></strong>, 
                    TURNO <p1 class="turno"><?= Html::encode($cartas[0]['turno'] ?? 'Turno no disponible') ?></p1> 
                    HA SIDO ACEPTADA (O) para realizar sus <strong>PRÁCTICAS DE EJECUCIÓN DE COMPETENCIAS</strong> 
                    en <p1 class="nombre-empresa"><?= Html::encode($cartas[0]['nombre_empresa'] ?? 'Empresa no disponible') ?></p1> 
                    en el área de <p1 class="area-empresa"><?= Html::encode($cartas[0]['area_empresa'] ?? 'Área no disponible') ?></p1>, 
                    iniciando a partir del <p1 class="fecha-inicial"><?= isset($cartas[0]['fecha_inicial']) ? traducirMes(Yii::$app->formatter->asDate($cartas[0]['fecha_inicial'], 'php:j \d\e F \d\e Y')) : 'Fecha no disponible' ?></p1> 
                    al <p1 class="fecha-final"><?= isset($cartas[0]['fecha_final']) ? traducirMes(Yii::$app->formatter->asDate($cartas[0]['fecha_final'], 'php:j \d\e F \d\e Y')) : 'Fecha no disponible' ?></p1> 
                    <p1 class="horarios"><?= Html::encode($cartas[0]['horarios'] ?? 'Horario no disponible') ?></p1>.</p>
                    <p class="final">Sin otro particular por el momento, le envío un cordial saludo.</p>
                </div>
                <div class="firma">
                    <p class="primero">ATENTAMENTE</p>
                    <p><p1 class="cargo-jefe"><?= Html::encode($cartas[0]['cargo_jefe'] ?? 'Cargo no disponible') ?></p1> <p1 class="nombre-jefe"><?= Html::encode($cartas[0]['nombre_jefe'] ?? 'Nombre no disponible') ?></p1></p>
                    <p>NOMBRE Y FIRMA (SELLO) CARGO DEL JEFE INMEDIATO</p>
                </div>
            <?php else: ?> 
                <p>No se encontró información para el usuario.</p>
            <?php endif; ?>
        </main>
        <footer>
        </footer>
    </body>
</html>

