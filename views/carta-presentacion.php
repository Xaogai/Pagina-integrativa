<?php
use yii\helpers\Html; // Importa la clase Html
?>

<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de Presentación</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
    <header>
        <div class="informacion">
            <p>Subsecretaría de Educación Media Superior<br>
                Dirección General de Educación Media Superior</p>
            <p>Dirección de Bachillerato Tecnológico</p>
            <p>Subdirección Regional, Valle de Toluca</p>
            <p>Supervisión Escolar BT006</p>
            <p>CBT No. 2, Metepec</p>
            <h2>Alumno (ID: <?= Yii::$app->session->get('user_id') ?>)</h2> <!-- Muestra el ID del usuario -->
        </div>
    </header>
    <main>
        <?php foreach ($cartas as $carta): ?>
            <p class="title">CBT No. 2, METEPEC</p>
            <div class="fecha">San Bartolomé, Tlaltelulco, Metepec, Méx., a <span class="fecha_emision"><?= Html::encode($carta['fecha_emision'] ?? 'Fecha no disponible') ?></span></div>
            <p class="presente">P R E S E N T E.</p>
            <div class="contenido">
                <p>El que suscribe <strong>Mtro. en D. P. Francisco Ricardo López Sotelo, Director Escolar del CBT No. 2, METEPEC</strong>, por este conducto informo a usted que nuestra institución tiene como misión contribuir a una educación integral del estudiante basada en competencias, promoviendo la adquisición de un pensamiento crítico para dar respuesta inmediata a las exigencias de las demandas sociales y laborales, bajo un ambiente de respeto, trabajo en equipo y responsabilidad.</p>
                
                <p>Derivado de lo anterior y con base en el programa de estudios de la carrera <strong class="carrera"><?= Html::encode($carta['carrera'] ?? 'Carrera no disponible') ?></strong>, el estudiante deberá realizar en el <strong class="semestre"><?= Html::encode($carta['semestre']['nombre'] ?? 'Semestre no disponible') ?></strong> semestre las Prácticas de Ejecución de Competencias, con una duración de 100 hrs., a partir del <strong>día <span class="fecha-inicio"><?= Html::encode($carta['fecha_inicio'] ?? 'Fecha no disponible') ?></span> al <span class="fecha-final"><?= Html::encode($carta['fecha_termino'] ?? 'Fecha no disponible') ?></span></strong>.</p>
                
                <p>Por lo anterior, solicito su amable autorización para que el (la) estudiante: <span class="nombre-alumno"><?= Html::encode($carta['nombre_alumno'] . ' ' . $carta['apellido_paterno'] . ' ' . $carta['apellido_materno']) ?></span>, pueda llevar a cabo sus prácticas de ejecución de competencias en las instalaciones de la empresa que usted representa y, al finalizar, pueda extender LA CONSTANCIA DE COMPETENCIA LABORAL CORRESPONDIENTE AL MÓDULO III; DEMUESTRA LAS HABILIDADES EN UN PUESTO LABORAL DEL MODELO EDUCATIVO PARA LA EDUCACIÓN OBLIGATORIA (MEPEO, 2018), QUE AVALE SU CONCLUSIÓN (se entregará formato a usted), en la que se haga constar que el prestador (a) desarrolló adecuadamente las competencias profesionales indicadas en el programa de estudio del módulo de la carrera técnica.</p>
                
                <p>Cabe mencionar que el estudiante cuenta con número de IMSS: <span class="numero-imss"><?= Html::encode($carta['nss']) ?></span>, el cual podrá ser utilizado en caso de ser necesario.</p>
                
                <p>Con la confianza de poder contar con su valioso apoyo, agradezco de antemano el interés por contribuir en el proceso complementario de la formación en campo profesional y el desarrollo de nuestros estudiantes.</p>
            </div>
            <div class="firma">
                <p>A t e n t a m e n t e</p>
                <p>Mtro. en D. P. Francisco Ricardo López Sotelo</p>
                <p>Director Escolar</p>
            </div>
        <?php endforeach; ?>
    </main>
    <footer>
        <div class="pie">
            <p>Prolongación Josefa Ortiz de Domínguez S/N, San Bartolomé Tlaltelulco, Metepec, Estado de México C.P. 52160.</p>
            <p>Tel: (01 722) 1 98 08 68 Correo Electrónico: 15ECT0104D.CBT@edugem.gob.mx</p>
        </div>
    </footer>
</body>
</html>