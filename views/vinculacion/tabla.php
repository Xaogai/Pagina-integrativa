<?php
use yii\helpers\Html;

$this->title = 'Tabla';

$this->registerCssFile('@web/css/tabla.css');

    $turnos = [];
    $semestres = [];
    $ciclos = [];
    $carreras = [];
    $statuses = [];

    $tipo = $tipo ?? 'presentacion';
?>

<?= Html::csrfMetaTags()?>

<body>
    <header>
        <h2>Tabla</h2>
    </header>

    <main>
        <form id="filtros-form" action="<?= \yii\helpers\Url::to(['vinculacion/vinculacion/filter', 'tipo' => $tipo]) ?>">
            <div class="filtros">
                <div class="contenido completo">
                    <div class="titulo-filtro">Nombre u Apellido</div>
                    <input type="search" id="nombre-search" name="nombre" placeholder="Escribe aqui" />
                </div>

                <div class="contenido">
                    <div class="titulo-filtro">Turno</div>
                    <select name="turno" id="turno-select">
                        <option value="">Seleccione</option>
                        <?php foreach ($cartas as $carta): 
                            $valor = $carta['turno'];
                            if (!in_array($valor, $turnos)):
                                $turnos[] = $valor; ?>
                                <option value="<?= Html::encode($valor) ?>"><?= Html::encode($valor) ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>
                
                <div class="contenido">
                    <div class="titulo-filtro">Semestre</div>
                    <select name="semestre" id="semestre-select">
                        <option value="">Seleccione</option>
                        <?php foreach ($cartas as $carta): 
                            $valor = $carta['semestre']['nombre'];
                            if (!in_array($valor, $semestres)):
                                $semestres[] = $valor; ?>
                                <option value="<?= Html::encode($valor) ?>"><?= Html::encode($valor) ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div class="contenido">
                    <div class="titulo-filtro">Ciclo</div>
                    <select name="ciclo" id="ciclo-select">
                        <option value="">Seleccione</option>
                        <?php foreach ($cartas as $carta): 
                            $valor = $carta['ciclo_escolar'];
                            if (!in_array($valor, $ciclos)):
                                $ciclos[] = $valor; ?>
                                <option value="<?= Html::encode($valor) ?>"><?= Html::encode($valor) ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>
                
                <div class="contenido largo">
                    <div class="titulo-filtro">Carrera</div>
                    <select name="carrera" id="carrera-select">
                        <option value="">Seleccione</option>
                        <?php foreach ($cartas as $carta): 
                            $valor = $carta['carrera'];
                            if (!in_array($valor, $carreras)):
                                $carreras[] = $valor; ?>
                                <option value="<?= Html::encode($valor) ?>"><?= Html::encode($valor) ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div class="contenido">
                    <div class="titulo-filtro">Status</div>
                    <select name="status" id="status-select">
                        <option value="">Seleccione</option>
                        <?php foreach ($cartas as $carta): 
                            $valor = $carta['estatus'];
                            if (!in_array($valor, $statuses)):
                                $statuses[] = $valor;
                                $textoFormateado = ucwords(strtolower($valor)); ?>
                                <option value="<?= Html::encode($valor) ?>"><?= Html::encode($textoFormateado) ?></option>
                            <?php endif;
                        endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="botones">
                <div class="blank"></div>
                <button>Search</button>
                <input type="reset" value="Reset" />
            </div>
        </form>
        <div id="tabla-contenedor">
            <table>
                <thead>
                    <tr class="titulos">
                        <th class="hidden"></th>
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
                    <?php foreach ($cartas as $index => $carta): ?>
                        <tr class="datos">
                            <td class="hidden"><?= Html::encode($carta['id_alumno']) ?></td>
                            <td><?= Html::encode($carta['nombre']) ?></td>
                            <td><?= Html::encode($carta['apellido_paterno']) ?></td>
                            <td><?= Html::encode($carta['apellido_materno']) ?></td>
                            <td><?= Html::encode($carta['turno']) ?></td>
                            <td><?= Html::encode($carta['semestre']['nombre']) ?></td>
                            <td><?= Html::encode($carta['ciclo_escolar']) ?></td>
                            <td><?= Html::encode($carta['carrera']) ?></td>
                            <td><?= Html::encode(ucfirst(strtolower($carta['estatus']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script> 
        document.querySelectorAll('tr.datos').forEach(function(row) {
        row.addEventListener('click', function() {
            const id = this.querySelector('td.hidden').innerText.trim();
            
            // Extrae el tipo de carta de la URL actual (ej: "aceptacion", "datos")
            const currentPath = window.location.pathname; // Ej: "/vinculacion/aceptacion"
            const tipo = currentPath.split('/').pop(); // Obtiene el último segmento

            // Mapeo de tipos a rutas (ajusta según tus rutas Yii2)
            const rutas = {
                'aceptacion': '/cartas-vinc/validar-aceptacion',
                'datos': '/cartas-vinc/validar-datos',
                'presentacion': '/cartas-vinc/validar-presentacion',
                'terminacion': '/cartas-vinc/validar-termino'
            };

            // Crear formulario dinámico
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = rutas[tipo] || rutas.aceptacion; // Usa la ruta según el tipo (o default)
            form.target = '_blank';

            // Agregar campos (ID + CSRF)
            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = id;
            form.appendChild(inputId);

            // Token CSRF (como en tu código original)
            const csrfParam = document.querySelector('meta[name="csrf-param"]').content;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const inputCsrf = document.createElement('input');
            inputCsrf.type = 'hidden';
            inputCsrf.name = csrfParam;
            inputCsrf.value = csrfToken;
            form.appendChild(inputCsrf);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        });
    });
    </script>

    <?php
    $this->registerJs(<<<JS
        $('#filtros-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = form.serialize();
            const currentUrl = window.location.pathname;

            $.ajax({
                url: currentUrl,
                data: formData,
                type: 'get',
                success: function(response) {
                    $('#tabla-contenedor').html(
                        $(response).find('#tabla-contenedor').html()
                    );
                    
                    const newTable = $(response).find('table');
                    $('table').replaceWith(newTable);

                    const newUrl = currentUrl + '?' + formData;
                    history.replaceState(null, '', newUrl);
                }
            });
        });
    JS
    );
    ?>

</body>

