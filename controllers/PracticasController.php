<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;
use app\models\CartaPresentacion; 
use app\models\CartaAceptacion; 
use app\models\CartaTermino;
use app\models\HojaDatos;
use app\models\FondoCbt;

class PracticasController extends Controller
{   
    
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

        $fondo = FondoCbt::find()->where(['status' => 'VIGENTE'])->one();
        $rutaFondo = Yii::getAlias('@webroot/uploads/fondos/' . $fondo->fondo_imagen);

        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-presentacion.css');
        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-presentacion', [
            'cartas' => $cartas, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->SetDefaultBodyCSS('background', "url('$rutaFondo')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

        $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        return $mpdf->Output('carta-presentacion.pdf', 'I');
    }

    public function actionAceptacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');
        
        $cartas = CartaAceptacion::find()
            ->select([
                'carta_aceptacion.*',
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
                'empresa.cargo AS cargo_jefe',
                'empresa.logo AS logo'
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

        $fondo = FondoCbt::find()->where(['status' => 'VIGENTE'])->one();
        $rutaFondo = Yii::getAlias('@webroot/uploads/fondos/' . $fondo->fondo_imagen);

        $resetCssFile = Yii::getAlias('@webroot/css/reset.css');
        $styleCssFile = Yii::getAlias('@webroot/css/style-aceptacion.css');

        $resetCss = file_get_contents($resetCssFile);
        $styleCss = file_get_contents($styleCssFile);

        $css = $resetCss . "\n" . $styleCss;

        $html = $this->renderPartial('//carta-aceptacion', [
            'cartas' => $cartas, 
        ]);

        $mpdf = new Mpdf();

        $mpdf->SetDefaultBodyCSS('background', "url('$rutaFondo')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);

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
                'empresa.logo AS logo',
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

    public function actionDatos()
    {
        $idUsuario = Yii::$app->session->get('user_id');
    
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

        #var_dump($datos); exit;
            
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
}