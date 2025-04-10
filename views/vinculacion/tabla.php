<?php
use yii\helpers\Html;

$this->title = 'Tabla';

$this->registerCssFile('@web/css/reset.css');
$this->registerCssFile('@web/css/tabla.css');
?>

<body>
    <header>
        <h2>Tabla</h2>
    </header>

    <main>
        <div class="filtros">
            <select name="nombre" id="nombre-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="apellido-paterno" id="apellido-paterno-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="apellido-materno" id="apellido-materno-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="turno" id="turno-select">
                <option value="">Seleccione</option>
                <option value="matutino">Matutino</option>
                <option value="verspertino">Verspertino</option>
            </select>

            <select name="semestre" id="semestre-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="ciclo" id="ciclo-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="carrera" id="carrera-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>

            <select name="status" id="status-select">
                <option value="">Seleccione</option>
                <option value="Dato-1">Dato 1</option>
                <option value="Dato-2">Dato 2</option>
                <option value="Dato-3">Dato 3</option>
            </select>
        </div>

        <div class="botones">
            <button>Search</button>
            <input type="reset" value="Reset" />
        </div>
        <table>
            <thead>
                <tr class="titulos">
                    <th></th>
                    <th>Nombre</th>
                    <th>Apellido paterno</th>
                    <th>Apellido materno</th>
                    <th>Turno</th>
                    <th>Semestre</th>
                    <th>Ciclo</th>
                    <th>Carrera</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="datos">
                    <td>No</td>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                    <td>Dato 3</td>
                    <td>Dato 4</td>
                    <td>Dato 5</td>
                    <td>Dato 6</td>
                    <td>Dato 7</td>
                    <td>Dato 8</td>
                </tr>
                <tr class="datos">
                    <td>No</td>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                    <td>Dato 3</td>
                    <td>Dato 4</td>
                    <td>Dato 5</td>
                    <td>Dato 6</td>
                    <td>Dato 7</td>
                    <td>Dato 8</td>
                </tr>
                <tr class="datos">
                    <td>No</td>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                    <td>Dato 3</td>
                    <td>Dato 4</td>
                    <td>Dato 5</td>
                    <td>Dato 6</td>
                    <td>Dato 7</td>
                    <td>Dato 8</td>
                </tr>
                <tr class="datos">
                    <td>No</td>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                    <td>Dato 3</td>
                    <td>Dato 4</td>
                    <td>Dato 5</td>
                    <td>Dato 6</td>
                    <td>Dato 7</td>
                    <td>Dato 8</td>
                </tr>
                <tr class="datos">
                    <td>No</td>
                    <td>Dato 1</td>
                    <td>Dato 2</td>
                    <td>Dato 3</td>
                    <td>Dato 4</td>
                    <td>Dato 5</td>
                    <td>Dato 6</td>
                    <td>Dato 7</td>
                    <td>Dato 8</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>
