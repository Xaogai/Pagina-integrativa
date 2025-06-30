<?php
namespace app\controllers\vinculacion;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;
use app\models\CartaPresentacion; 
use app\models\CartaAceptacion; 
use app\models\CartaTermino;
use app\models\HojaDatos;
use yii\filters\AccessControl;

class CartasVincController extends Controller
{   
    private $idUsuario;

    public function actionPresentacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');
        
        $cartas = CartaPresentacion::find()
            ->select([
                'carta_presentacion.*',
                'alumnos.nombre AS nombre_alumno',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'alumnos.nss',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar'
            ])
            ->joinWith(['alumno', 'alumno.carrera', 'semestre', 'ciclo'])
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario') 
            ->where(['usuarios.id_usuario' => $idUsuario]) 
            ->asArray()
            ->all();
        
        # SI carta-presentacion EN LA BASE NO TIENE DATOS
        #var_dump($cartas); exit;

        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-presentacion.css');
        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-presentacion', [
            'cartas' => $cartas, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-presentacion.pdf', 'I');
    }

    public function actionAceptacion()
    {   

        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));

        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }

        $this->idUsuario = $idUsuario;
        
        $cartas = CartaAceptacion::find()
            ->select([
                'carta_aceptacion.*',
                'alumnos.id_alumno',
                'alumnos.nombre AS nombre_alumno',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'turnos.nombre AS turno',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar',
                'empresa.nombre AS nombre_empresa',
                'carta_aceptacion.area AS area_empresa',
                'carta_aceptacion.fecha_inicio_servicio AS fecha_inicial',
                'carta_aceptacion.fecha_termino_servicio AS fecha_final',
                'carta_aceptacion.horario AS horarios',
                'empresa.jefe_inmediato AS nombre_jefe',
                'empresa.cargo AS cargo_jefe'
            ])
            ->joinWith([
                'alumno' => function($query) {
                    $query->joinWith(['carrera', 'turno']);
                },
                'alumno.hojaDatos', // Relación con hoja_datos
                'semestre', 
                'ciclo'
            ])
            ->innerJoin('empresa', 'empresa.id_empresa = hoja_datos.id_empresa')
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->asArray()
            ->all();

        #var_dump($cartas); exit;

        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-aceptacion.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-aceptacion', [
            'cartas' => $cartas, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-aceptacion.pdf', 'I');
    }

    public function actionTerminacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');

        $carta = CartaTermino::find()
            ->select([
                'carta_termino.*',
                'alumnos.nombre AS nombre_alumno',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'carrera.id_carrera',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'turnos.nombre AS nombre_turno',
                'empresa.nombre AS nombre_empresa',
                'empresa.jefe_inmediato',
                'empresa.cargo',
                'cualidades.cualidades AS cualidades_carrera' 
            ])
            ->joinWith(['alumno', 'alumno.carrera', 'semestre'])
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->innerJoin('hoja_datos', 'hoja_datos.id_alumno = alumnos.id_alumno')
            ->innerJoin('empresa', 'empresa.id_empresa = hoja_datos.id_empresa')
            ->innerJoin('cualidades', 'cualidades.id_cualidades = carrera.id_cualidades')
            ->innerJoin('turnos', 'turnos.id_turno = alumnos.id_turno')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->asArray()
            ->one();

        #var_dump($carta); exit;

        if (!empty($carta['cualidades_carrera'])) {
            $cualidadesArray = explode(',', $carta['cualidades_carrera']);
            $cualidadesArray = array_map('trim', $cualidadesArray);
            $carta['cualidades_separadas'] = $cualidadesArray;
        } else {
            $carta['cualidades_separadas'] = [];
        }

        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-termino.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-termino', [
            'carta' => $carta, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-termino.pdf', 'I');
    }

    public function actionValidarAceptacion()
    {
        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));  
        
        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }
        
        // Obtener la carta
        $carta = CartaAceptacion::find()
            ->innerJoin('alumnos', 'alumnos.id_alumno = carta_aceptacion.id_alumno')
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->one();
        
        if (!$carta) {
            throw new \yii\web\NotFoundHttpException('No se encontró la carta de aceptación.');
        }

        return $this->render('validar-aceptacion', [
            'carta' => $carta,
            'idUsuario' => $idUsuario,
            'modelCartaAceptacion' => $carta // Pasamos el modelo para el formulario
        ]);
    }
    
        public function actionValidarDatos()
    {
        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));  
        
        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }
        
        // Obtener la carta de DATOS (ajusta la tabla según tu BD)
        $carta = HojaDatos::find()
            ->innerJoin('alumnos', 'alumnos.id_alumno = hoja_datos.id_alumno')
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->one();
        
        if (!$carta) {
            throw new \yii\web\NotFoundHttpException('No se encontró la carta de datos.');
        }

        return $this->render('validar-datos', [
            'carta' => $carta,
            'idUsuario' => $idUsuario,
            'modelHojaDatos' => $carta
        ]);
    }

    public function actionValidarPresentacion()
    {
        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));  
        
        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }
        
        // Obtener la carta de PRESENTACIÓN
        $carta = CartaPresentacion::find()
            ->innerJoin('alumnos', 'alumnos.id_alumno = carta_presentacion.id_alumno')
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->one();
        
        if (!$carta) {
            throw new \yii\web\NotFoundHttpException('No se encontró la carta de presentación.');
        }

        return $this->render('validar-presentacion', [
            'carta' => $carta,
            'idUsuario' => $idUsuario,
            'modelCartaPresentacion' => $carta
        ]);
    }

    public function actionValidarTermino()
    {
        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));  
        
        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }
        
        // Obtener la carta de TERMINACIÓN
        $carta = CartaTermino::find()
            ->innerJoin('alumnos', 'alumnos.id_alumno = carta_termino.id_alumno')
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->where(['usuarios.id_usuario' => $idUsuario])
            ->one();
        
        if (!$carta) {
            throw new \yii\web\NotFoundHttpException('No se encontró la carta de terminación.');
        }

        return $this->render('validar-termino', [
            'carta' => $carta,
            'idUsuario' => $idUsuario,
            'modelCartaTermino' => $carta
        ]);
    }

 /**
 * Acción genérica para aceptar con parámetros predefinidos
 * 
 * @param string $modelClass Clase del modelo
 * @return \yii\web\Response
 */
public function actionAceptarGenerico($modelClass)
{
    return $this->actionAceptarGenericoCompleto(
        $modelClass,
        'status',
        constant("$modelClass::STATUS_ACEPTADO"), // Usamos constantes del modelo
        'alumno',
        'usuarios',
        ['documento/index'],
        'Registro aceptado correctamente.',
        'No se encontró el registro.'
    );
}

/**
 * Acción genérica para rechazar con parámetros predefinidos
 * 
 * @param string $modelClass Clase del modelo
 * @return \yii\web\Response
 */
public function actionRechazarGenerico($modelClass)
{
    return $this->actionRechazarGenericoCompleto(
        $modelClass,
        'status',
        constant("$modelClass::STATUS_RECHAZADO"), // Usamos constantes del modelo
        'comentario_vinculacion',
        'alumno',
        'usuarios',
        ['/vinculacion'],
        'Registro rechazado correctamente.',
        'No se encontró el registro.'
    );
}

/**
 * Versión completa con todos parámetros (para uso interno)
 */
protected function actionAceptarGenericoCompleto(
    $modelClass, $statusField, $acceptedValue, $relationName, 
    $userRelation, $redirectRoute, $successMessage, $errorMessage
) {
    $request = Yii::$app->request;
    $idUsuario = $request->post('id');
    
    $model = $modelClass::find()
        ->innerJoinWith([$relationName => function($query) use ($idUsuario, $userRelation, $relationName) {
            $query->innerJoin($userRelation, "$userRelation.id_usuario = {$relationName}s.id_usuario")
                ->andWhere(["$userRelation.id_usuario" => $idUsuario]);
        }])
        ->one();

    if ($model) {
        $model->$statusField = $acceptedValue;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $successMessage);
        } else {
            Yii::$app->session->setFlash('error', 'Error al aceptar: ' . print_r($model->errors, true));
        }
    } else {
        Yii::$app->session->setFlash('error', $errorMessage);
    }
    
    return $this->redirect('/vinculacion');
}

/**
 * Versión completa con todos parámetros (para uso interno)
 */
protected function actionRechazarGenericoCompleto(
    $modelClass, $statusField, $rejectedValue, $commentField, 
    $relationName, $userRelation, $redirectRoute, $successMessage, $errorMessage
) {
    $request = Yii::$app->request;
    $idUsuario = $request->post('id');
    $comentario = $request->post('comentario');
    
    $model = $modelClass::find()
        ->innerJoinWith([$relationName => function($query) use ($idUsuario, $userRelation, $relationName) {
            $query->innerJoin($userRelation, "$userRelation.id_usuario = {$relationName}s.id_usuario")
                ->andWhere(["$userRelation.id_usuario" => $idUsuario]);
        }])
        ->one();

    if ($model) {
        $model->$statusField = $rejectedValue;
        $model->$commentField = $comentario;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $successMessage);
        } else {
            Yii::$app->session->setFlash('error', 'Error al rechazar: ' . print_r($model->errors, true));
        }
    } else {
        Yii::$app->session->setFlash('error', $errorMessage);
    }
    
    return $this->redirect('/vinculacion');
}


    public function actionDatos()
    {
        $request = Yii::$app->request;
        $idUsuario = $request->get('id', $request->post('id'));

        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }

        $this->idUsuario = $idUsuario;
        $datos = HojaDatos::find()
        ->select([
            'alumnos.nombre AS nombre_alumno',
            'alumnos.apellido_paterno',
            'alumnos.apellido_materno',
            'alumnos.curp',
            'alumnos.nss',
            'alumnos.calle',
            'alumnos.numero',
            'alumnos.colonia',
            'alumnos.codigo_postal',
            'alumnos.telefono_uno AS telefono_alumno_uno',
            'alumnos.telefono_dos AS telefono_alumno_dos',
            'carrera.nombre AS carrera',
            'semestre.nombre AS semestre',
            'turnos.nombre AS turno',
            'empresa.nombre AS nombre_empresa',
            'empresa.jefe_inmediato',
            'empresa.cargo AS perfil_jefe',
            'empresa.calle AS calle_empresa',
            'empresa.colonia AS colonia_empresa',
            'empresa.numero AS numero_empresa',
            'empresa.codigo_postal AS cp_empresa',
            'empresa.municipio AS municipio_empresa',
            'empresa.telefono_uno AS telefono_empresa1',
            'empresa.telefono_dos AS telefono_empresa2',
            'empresa.correo AS correo_empresa',
            'empresa.rfc AS rfc_empresa'
        ])
        ->joinWith(['alumno', 'alumno.carrera', 'semestre', 'alumno.turno'])
        ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
        ->innerJoin('empresa', 'empresa.id_empresa = hoja_datos.id_empresa')
        ->where(['usuarios.id_usuario' => $idUsuario])
        ->asArray()
        ->one();
        //var_dump($datos); exit;
        // Datos combinados
        $datos['nombre_completo'] = $datos['nombre_alumno'] . ' ' . $datos['apellido_paterno'] . ' ' . $datos['apellido_materno'];
        $datos['grupo_turno'] = $datos['semestre'] . ' - ' . $datos['turno'];

        // Domicilio
        $datos['domicilio_completo'] = implode(', ', array_filter([
            $datos['calle'],
            $datos['numero'],
            $datos['colonia'],
            'CP. ' . $datos['codigo_postal'],
            $datos['municipio'] ?? ''
        ]));

        // Empresa
        $datos['direccion_empresa'] = implode(', ', array_filter([
            $datos['calle_empresa'],
            $datos['numero_empresa'],
            $datos['colonia_empresa'],
            'CP. ' . $datos['cp_empresa'],
            $datos['municipio_empresa']
        ]));
    
        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-datos.css');
        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;
        $html = $this->renderPartial('//carta-datos', [
            'datos' => $datos, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-datos.pdf', 'I');
    }

    // Para CartaPresentacion
    public function actionAceptarPresentacion()
    {
        return $this->actionAceptarGenerico('app\models\CartaPresentacion');
    }

    public function actionRechazarPresentacion()
    {
        return $this->actionRechazarGenerico('app\models\CartaPresentacion');
    }

    // Para HojaDatos
    public function actionAceptarHojaDatos()
    {
        return $this->actionAceptarGenerico('app\models\HojaDatos');
    }

    public function actionRechazarHojaDatos()
    {
        return $this->actionRechazarGenerico('app\models\HojaDatos');
    }

    // Para CartaAceptacion
    public function actionAceptarAceptacion()
    {
        return $this->actionAceptarGenerico('app\models\CartaAceptacion');
    }

    public function actionRechazarAceptacion()
    {
        return $this->actionRechazarGenerico('app\models\CartaAceptacion');
    }

    // Para Terminacion
    public function actionAceptarTermino()
    {
        return $this->actionAceptarGenerico('app\models\CartaTermino');
    }

    public function actionRechazarTermino()
    {
        return $this->actionRechazarGenerico('app\models\CartaTermino');
    }
    #public function behaviors()
    #{
    #    return [
    #        'access' => [
    #            'class' => AccessControl::class,
    #            'only' => ['index', 'aceptacion', 'presentacion'],
    #            'rules' => [
    #                [
    #                    'allow' => true,
    #                    'roles' => ['@'], // Solo usuarios autenticados
    #                ],
    #            ],
    #        ],
    #    ];
    #}

}