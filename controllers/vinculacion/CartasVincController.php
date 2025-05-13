<?php
namespace app\controllers\vinculacion;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;
use app\models\CartaPresentacion; 
use app\models\CartaAceptacion; 
use app\models\CartaTermino;
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
        $idUsuario = $request->post('id');  
    
        if (!$idUsuario) {
            throw new \yii\web\BadRequestHttpException('ID de usuario no proporcionado.');
        }
    
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

    
        // Renderiza nueva vista
        return $this->render('/validar-aceptacion', [
            'cartas' => $cartas,
            'idUsuario' => $idUsuario
        ]);
    }
    

    public function actionAceptarAceptacion()
    {
        $id = Yii::$app->request->post('id');
        $carta = CartaAceptacion::find()->where(['id_usuario' => $id])->one();
        if ($carta) {
            $carta->estado = 'ACEPTADO';
            $carta->save();
        }
        return $this->redirect(['documento/index']); // O a donde quieras
    }
    
    public function actionRechazarAceptacion()
    {
        $id = Yii::$app->request->post('id');
        $comentario = Yii::$app->request->post('comentario');
        
        $carta = CartaAceptacion::find()->where(['id_usuario' => $id])->one();
        if ($carta) {
            $carta->estado = 'RECHAZADO';
            $carta->comentario_rechazo = $comentario; // si tienes ese campo
            $carta->save();
        }
        return $this->redirect(['documento/index']);
    }




    public function actionDatos()
    {
        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-datos.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-datos');

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('Hoja-datos.pdf', 'I');
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'aceptacion', 'presentacion'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
        ];
    }

}