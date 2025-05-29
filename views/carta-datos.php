<?php
use yii\helpers\Html;
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
            <div class="informacion">
                <p><strong>Subsecretaría de Educación Media Superior<br>
                    Dirección General de Educación Media Superior</strong></p>
                <p>Dirección de Bachillerato Tecnológico</p>
                <p>Subdirección Regional, Valle de Toluca</p>
                <p>Supervisión Escolar BT006</p>
                <p>CBT No. 2, Metepec</p>
            </div>
        </header>
        <main>
            <div class="titulo">
                <p>CBT No. 2, METEPEC</p>
                <p><br>HOJA DE DATOS DE PRÁCTICAS DE EJECUCIÓN</p>
            </div>
            <div class="contenido">
                <p class="subtitulo">DATOS DEL ALUMNO</p>
                <table class="datos-alumno">
                    <tr>
                        <th class="dato">NOMBRE COMPLETO</th>
                        <th class="nombre-alumno"><?= Html::encode($datos['nombre_completo'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">GRUPO Y TURNO</th>
                        <th class="grupoTurno-alumno"><?= Html::encode($datos['grupo_turno'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">CARRERA TÉCNICA</th>
                        <th class="carrera-alumno"><?= Html::encode($datos['carrera'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">CURP</th>
                        <th class="curp-alumno"><?= Html::encode($datos['curp'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">NÚMERO DE SEGURO SOCIAL (IMSS)</th>
                        <th class="nomImss-alumno"><?= Html::encode($datos['nss'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">OTRA INSTITUCIÓN DE SALUD</th>
                    </tr>
                    <tr>
                        <th class="dato">DOMICILIO</th>
                        <th class="domicilio-alumno"><?= Html::encode($datos['domicilio_completo'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">TELÉFONO 1</th>
                        <th class="telefono1-alumno"><?= Html::encode($datos['telefono_alumno_uno'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">TELÉFONO 2</th>
                        <th class="telefono2-alumno"><?= Html::encode($datos['telefono_alumno_dos'] ?? '') ?></th>
                    </tr>
                </table>
                <p class="subtitulo">DATOS DEL ESCENARIO REAL (LUGAR DE LAS PRÁCTICAS)</p>
                <table class="datos-empresa">
                    <tr>
                        <th class="dato">NOMBRE DEL JEFE O RESPONSABLE</th>
                        <th class="nombre-jefe"><?= Html::encode($datos['jefe_inmediato'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">PERFIL PROFESIONAL DEL JEFE:</th>
                        <th class="titulo-jefe"><?= Html::encode($datos['perfil_jefe'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">CARGO EN LA EMPRESA O DEPENDENCIA</th>
                        <th class="cargo-jefe"><?= Html::encode($datos['perfil_jefe'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">NOMBRE DEL LUGAR</th>
                        <th class="nombre-empresa"><?= Html::encode($datos['nombre_empresa'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">DIRECCIÓN DEL ESCENARIO REAL</th>
                        <th class="direccion-empresa"><?= Html::encode($datos['direccion_empresa'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">TELÉFONO 1</th>
                        <th class="telefono1-empresa"><?= Html::encode($datos['telefono_empresa1'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">TELÉFONO 2</th>
                        <th class="teefono2-empresa"><?= Html::encode($datos['telefono_empresa2'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">CORREO ELECTRÓNICO</th>
                        <th class="correo-empresa"><?= Html::encode($datos['correo_empresa'] ?? '') ?></th>
                    </tr>
                    <tr>
                        <th class="dato">RFC DEL ESTABLECIMIENTO</th>
                        <th class="rfc-empresa"><?= Html::encode($datos['rfc_empresa'] ?? '') ?></th>
                    </tr>
                </table>
            </div>
            <div class="firma">
                <p>FIRMA Y NOMBRE DEL PADRE O TUTOR _____________________________________________________</p>
                <p>EN TINTA AZUL</p>
            </div>
        </main>
    </body>
</html>