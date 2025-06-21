<?php
use yii\helpers\Html;

$this->title = 'Permisos';

$this->registerCssFile('@web/css/permisos.css');
?>

<body>
    <header>
        <h2 class="titulo-pagina">Permisos</h2>
    </header>

    <main>
        <form class="form-permisos">
            <label class="titulo-form">Usuario</label>
            <select name="Nombre-usuario">
                <option value="" selected>Selecciona un usuario</option>
                <option value="Usuario">Usuario 1</option>
                <option value="Usuario">Usuario 2</option>
                <option value="Usuario">Usuario 3</option>
            </select>

            <div class="informacion-usuario">
                <div class="usuario">
                    <div><strong>Nombre del usuario:</strong></div>
                    <div class="info">Usuario 1</div>
                </div>
                <div class="tipo-usuario">
                    <div><strong>Tipo de usuario:</strong></div>
                    <div class="info">Mini vinculacion</div>
                </div>
            </div>

            <div class="permisos-checkbox">
                <div class="titulo-form">Activar permisos</div>
                <div class="container">
                    <input type="checkbox" id="visualizar" name="visualizar" checked />
                    <label for="visualizar">Visualizar cartas</label>
                </div>
                <div class="container">
                    <input type="checkbox" id="aceptar" name="aceptar"/>
                    <label for="aceptar">Aceptar, rechazar, corregir cartas</label>
                </div>
            </div>
        </form>
    </main>

</body>
