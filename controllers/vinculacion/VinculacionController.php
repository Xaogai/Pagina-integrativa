<?php

namespace app\controllers\vinculacion;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
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

    private function getFilteredCartas($modelClass)
    {
        $request = Yii::$app->request;

        // Parámetros de filtrado
        $nombre = $request->get('nombre');
        $turno = $request->get('turno');
        $semestre = $request->get('semestre');
        $ciclo = $request->get('ciclo');
        $carrera = $request->get('carrera');
        $status = $request->get('status');

        // Configurar consulta base
        $query = $modelClass::find()
            ->select([
                "{$modelClass::tableName()}.*",
                'alumnos.nombre',
                'alumnos.apellido_paterno',
                'alumnos.apellido_materno',
                'turnos.nombre AS turno',
                'carrera.nombre AS carrera',
                'semestre.nombre AS semestre',
                'ciclo_escolar.ciclo AS ciclo_escolar',
                "{$modelClass::tableName()}.status AS estatus",
            ])
            ->joinWith([
                'alumno' => function($query) {
                    $query->joinWith(['carrera', 'turno']);
                },
                'semestre',
                'ciclo'
            ]);

        // Aplicar filtros
        $query->andFilterWhere(['like', 'alumnos.nombre', $nombre])
            ->andFilterWhere(['like', 'turnos.nombre', $turno])
            ->andFilterWhere(['like', 'semestre.nombre', $semestre])
            ->andFilterWhere(['like', 'ciclo_escolar.ciclo', $ciclo])
            ->andFilterWhere(['like', 'carrera.nombre', $carrera])
            ->andFilterWhere(['like', "{$modelClass::tableName()}.status", $status]);

        return $query->asArray()->all();
    }

    public function actionPresentacion()
    {
        $cartas = $this->getFilteredCartas(CartaPresentacion::class);
        
        return $this->render('/vinculacion/hoja-presentacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionDatos()
    {
        $cartas = $this->getFilteredCartas(CartaPresentacion::class);
        
        return $this->render('/vinculacion/hoja-datos', [
            'cartas' => $cartas,
        ]);
    }

    public function actionAceptacion()
    {
        $cartas = $this->getFilteredCartas(CartaAceptacion::class);
        
        return $this->render('/vinculacion/hoja-aceptacion', [
            'cartas' => $cartas,
        ]);
    }

    public function actionTerminacion()
    {
        $cartas = $this->getFilteredCartas(CartaTermino::class);
        
        return $this->render('/vinculacion/hoja-termino', [
            'cartas' => $cartas,
        ]);
    }

    public function actionPermisos()
    {
        return $this->render('/vinculacion/permisos');
    }
    
    public function actionFilter()
    {
        $request = Yii::$app->request;
        $tipo = $request->get('tipo', 'presentacion');
        
        // Determinar el modelo base según el tipo
        switch ($tipo) {
            case 'aceptacion':
                $modelClass = CartaAceptacion::class;
                break;
            case 'terminacion':
                $modelClass = CartaTermino::class;
                break;
            default:
                $modelClass = CartaPresentacion::class;
        }

        $cartas = $this->getFilteredCartas($modelClass);

        if ($request->isAjax) {
            return $this->renderAjax('tabla', [
                'cartas' => $cartas,
                'tipo' => $tipo
            ]);
        }
    
        // Renderizar la vista correspondiente según el tipo
        $viewMap = [
            'presentacion' => '/vinculacion/hoja-presentacion',
            'aceptacion' => '/vinculacion/hoja-aceptacion',
            'terminacion' => '/vinculacion/hoja-termino'
        ];
    
        return $this->render($viewMap[$tipo], [
            'cartas' => $cartas,
        ]);
    }
}
