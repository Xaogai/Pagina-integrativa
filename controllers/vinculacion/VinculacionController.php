<?php

namespace app\controllers\vinculacion;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\models\CartaPresentacion; 
use app\models\CartaAceptacion; 
use app\models\CartaTermino;

class VinculacionController extends Controller
{
    public $layout = 'main_vinculacion';

    public function actionIndex()
    {
        return $this->render('/vinculacion/index');
    }

    public function actionView()
    {
        return $this->render('/vinculacion/view', [

        ]);
    }

    public function actionPresentacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');

        $cartas = CartaPresentacion::find()
            ->select([
                'alumnos.nombre',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'turnos.nombre AS turno',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar',
                'carta_presentacion.status AS estatus',
            ])
            ->joinWith([
                'alumno' => function($query) {
                    $query->joinWith(['carrera', 'turno']);
                },
                'semestre',
                'ciclo'
            ])
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->asArray()
            ->all();
            var_dump($cartas); exit;

        return $this->renderPartial('/vinculacion/hoja-presentacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionAceptacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');
    
        $cartas = CartaAceptacion::find()
            ->select([
                'alumnos.nombre',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'turnos.nombre AS turno',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar',
                'carta_aceptacion.status AS estatus',
            ])
            ->joinWith([
                'alumno' => function($query) {
                    $query->joinWith(['carrera', 'turno']);
                },
                'semestre',
                'ciclo'
            ])
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->asArray()
            ->all();
            var_dump($cartas); exit;
    
        return $this->renderPartial('/vinculacion/hoja-aceptacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionTerminacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');
    
        $cartas = CartaTermino::find()
            ->select([
                'alumnos.nombre',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'turnos.nombre AS turno',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar',
                'carta_termino.status AS estatus',
            ])
            ->joinWith([
                'alumno' => function($query) {
                    $query->joinWith(['carrera', 'turno']);
                },
                'semestre',
                'ciclo'
            ])
            ->innerJoin('usuarios', 'usuarios.id_usuario = alumnos.id_usuario')
            ->asArray()
            ->all();
            var_dump($cartas); exit;
    
        return $this->renderPartial('/vinculacion/hoja-termino', [
            'cartas' => $cartas,
        ]);
    }
    

    
}
