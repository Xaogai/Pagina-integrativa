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
        $cartas = CartaPresentacion::find()
            ->select([
                'carta_presentacion.*',
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
            ->asArray()
            ->all();
            var_dump($cartas); exit;

        return $this->render('/vinculacion/hoja-presentacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionAceptacion()
    {
        $cartas = CartaAceptacion::find()
            ->select([
                'carta_aceptacion.*',
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
                'alumno.hojaDatos',
                'semestre',
                'ciclo'
            ])
            ->asArray()
            ->all();
    
        return $this->render('/vinculacion/hoja-aceptacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionTerminacion()
    {
        $cartas = CartaTermino::find()
            ->select([
                'carta_termino.*',
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
            ->asArray()
            ->all();
            var_dump($cartas); exit;
    
        return $this->render('/vinculacion/hoja-termino', [
            'cartas' => $cartas,
        ]);
    }
    

    
}
