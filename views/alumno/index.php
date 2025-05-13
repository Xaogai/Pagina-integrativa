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
                <tr class="datos">
                    <td>Hoja de datos</td>
                    <td>a</td>
                    <td>a</td>
                </tr>
                <tr class="datos">
                    <td>Presentacion</td>
                    <td>a</td>
                    <td>a</td>
                </tr>
                <tr class="datos">
                    <td>Aceptacion</td>
                    <td>a</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed velit nunc, gravida sit amet imperdiet in, dapibus nec metus. Nullam lacinia velit urna, sit amet lacinia est malesuada nec. Aenean rhoncus finibus luctus. Vivamus vehicula ut nunc a iaculis. Nunc ut hendrerit justo, vitae tristique tortor.</td>
                </tr>
                <tr class="datos">
                    <td>Termino</td>
                    <td>a</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed velit nunc, gravida sit amet imperdiet in, dapibus nec metus. Nullam lacinia velit urna, sit amet lacinia est malesuada nec. Aenean rhoncus finibus luctus. Vivamus vehicula ut nunc a iaculis. Nunc ut hendrerit justo, vitae tristique tortor. Cras id sapien velit. Nunc sed tortor condimentum, pretium dolor quis, pharetra magna. Morbi sit amet egestas est. Suspendisse mattis malesuada vehicula. Etiam tempus pulvinar justo quis molestie. Nunc facilisis elit vitae arcu consequat tristique. Nunc interdum dui sed arcu tristique rhoncus. Suspendisse dapibus mauris augue, sit amet scelerisque purus aliquet vel. Morbi fermentum eros et euismod ultricies.</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

