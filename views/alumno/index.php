<?php
use yii\helpers\Html;

$this->title = 'Panel del Alumno';

$this->registerCssFile('@web/css/tabla.css');
$this->registerCssFile('@web/css/tabla_alumno.css');
?>

<body>
    <header>
        <h2>Panel de control</h2>
        <p>Bienvenido al sistema de alumnos.</p>
    </header>
    <main>
        <table>
            <thead>
                <tr class="titulos">
                    <th>Carta</th>
                    <th>Status</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                <!-- Hoja de Datos -->
                <tr class="datos">
                    <td>Hoja de datos</td>
                    <td>
                        <?= $hoja_datos ? Html::encode($hoja_datos->status) : 'No aplica' ?>
                    </td>
                    <td>
                        <?= $hoja_datos ? 
                            ($hoja_datos->comentario_vinculacion ? 
                                Html::encode($hoja_datos->comentario_vinculacion) : 
                                'No hay comentarios') : 
                            'No aplica' ?>
                    </td>
                </tr>
                
                <!-- Carta de Presentación -->
                <tr class="datos">
                    <td>Presentación</td>
                    <td>
                        <?= $carta_presentacion ? Html::encode($carta_presentacion->status) : 'No aplica' ?>
                    </td>
                    <td>
                        <?= $carta_presentacion ? 
                            ($carta_presentacion->comentario_vinculacion ? 
                                Html::encode($carta_presentacion->comentario_vinculacion) : 
                                'No hay comentarios') : 
                            'No aplica' ?>
                    </td>
                </tr>
                
                <!-- Carta de Aceptación -->
                <tr class="datos">
                    <td>Aceptación</td>
                    <td>
                        <?= $carta_aceptacion ? Html::encode($carta_aceptacion->status) : 'No aplica' ?>
                    </td>
                    <td>
                        <?= $carta_aceptacion ? 
                            ($carta_aceptacion->comentario_vinculacion ? 
                                Html::encode($carta_aceptacion->comentario_vinculacion) : 
                                'No hay comentarios') : 
                            'No aplica' ?>
                    </td>
                </tr>
                
                <!-- Carta de Término -->
                <tr class="datos">
                    <td>Término</td>
                    <td>
                        <?= $carta_termino ? Html::encode($carta_termino->status) : 'No aplica' ?>
                    </td>
                    <td>
                        <?= $carta_termino ? 
                            ($carta_termino->comentario_vinculacion ? 
                                Html::encode($carta_termino->comentario_vinculacion) : 
                                'No hay comentarios') : 
                            'No aplica' ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</body>