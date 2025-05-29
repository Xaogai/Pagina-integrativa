<?php

namespace app\controllers\alumno;

use Yii;
use app\models\Alumnos;
use app\models\Institucion;
use app\models\Semestre;
use app\models\Grado;
use app\models\Grupos;
use app\models\Carrera;
use app\models\Turnos;
use app\models\CicloEscolar;
use app\models\HojaDatos;
use app\models\CartaPresentacion;
use app\models\CartaAceptacion;
use app\models\CartaTermino;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\helpers\VarDumper;


class AlumnoController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex() {
    // Obtener el ID del alumno (ejemplo: desde la sesión o autenticación)
    $id_alumno = Yii::$app->session->get('user_id'); // Ajusta según tu sistema
    
    // Consultar cada tipo de documento
    $hoja_datos = HojaDatos::find()->where(['id_alumno' => $id_alumno])->one();
    $carta_presentacion = CartaPresentacion::find()->where(['id_alumno' => $id_alumno])->one();
    $carta_aceptacion = CartaAceptacion::find()->where(['id_alumno' => $id_alumno])->one();
    $carta_termino = CartaTermino::find()->where(['id_alumno' => $id_alumno])->one();
    
    return $this->render('/alumno/index', [
        'hoja_datos' => $hoja_datos,
        'carta_presentacion' => $carta_presentacion,
        'carta_aceptacion' => $carta_aceptacion,
        'carta_termino' => $carta_termino,
    ]);
}

    public function actionDatosGenerales()
    {
        $user_id = Yii::$app->session->get('user_id');

        if (!$user_id) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta página.');
        }

        $model = Alumnos::findOne(['id_usuario' => $user_id]);

        if (!$model) {
            $model = new Alumnos();
            $model->id_usuario = $user_id;
        }

        $editable = Yii::$app->request->post('editable') == '1';

        if ($model->load(Yii::$app->request->post())) {
            $accion = Yii::$app->request->post('accion');

            if ($accion === 'aceptar') {
                if ($model->validate() && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Datos guardados correctamente.');
                    return $this->redirect(['datos-generales']);
                } else {
                    Yii::$app->session->setFlash('error', 'Error al guardar los datos.');
                }
                $editable = false;
            }
        }

        return $this->render('/alumno/datos-generales', [
            'model' => $model,
            'editable' => $editable,
            'semestres' => ArrayHelper::map(Semestre::find()->all(), 'id_semestre', 'nombre'),
            'instituciones' => ArrayHelper::map(Institucion::find()->all(), 'id_institucion', 'nombre'),
            'grados' => ArrayHelper::map(Grado::find()->all(), 'id_grado', 'nombre'),
            'grupos' => ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'),
            'carreras' => ArrayHelper::map(Carrera::find()->all(), 'id_carrera', 'nombre'),
            'turnos' => ArrayHelper::map(Turnos::find()->all(), 'id_turno', 'nombre'),
            'ciclos' => ArrayHelper::map(CicloEscolar::find()->all(), 'id_ciclo', 'ciclo'),
        ]);
    }

    public function actionCreate()
    {
        // Verificar sesión del alumno
        $idUsuario = Yii::$app->session->get('user_id');
        if (!$idUsuario) {
            Yii::$app->session->setFlash('error', 'No se encontró la sesión del usuario.');
            return $this->redirect(['site/login']);
        }


        // Buscar si ya existe un registro para este alumno
        $model = Alumnos::findOne(['id_usuario' => $idUsuario]);

        // Crear nuevo alumno
        $model = new Alumnos();
        $model->id_usuario = $idUsuario;
        $model->id_semestreactual = $this->obtenerSemestreActual();
        $model->id_ciclo = $this->obtenerCicloActual();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['datos-generales']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar: ' . print_r($model->errors, true));
            }
        }

        return $this->render('/alumno/datos-generales', [
            'model' => $model,
            'editable' => Yii::$app->request->post('editable', false),
            'semestres' => ArrayHelper::map(Semestre::find()->all(), 'id_semestre', 'nombre'),
            'instituciones' => ArrayHelper::map(Institucion::find()->all(), 'id_institucion', 'nombre'),
            'grados' => ArrayHelper::map(Grado::find()->all(), 'id_grado', 'nombre'),
            'grupos' => ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'nombre'),
            'carreras' => ArrayHelper::map(Carrera::find()->all(), 'id_carrera', 'nombre'),
            'turnos' => ArrayHelper::map(Turnos::find()->all(), 'id_turno', 'nombre'),
            'ciclos' => ArrayHelper::map(CicloEscolar::find()->all(), 'id_ciclo', 'ciclo'),
        ]);
    }

    public function actionView($id)
    {
        return $this->render('/alumno/view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        $model = Alumnos::find()
            ->with(['semestre', 'institucion', 'grado', 'grupo', 'carrera', 'turno', 'cicloEscolar'])
            ->where(['id_alumno' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El alumno no existe.');
    }

    private function obtenerSemestreActual()
    {
        // Aquí va la lógica para determinar el semestre actual, por ejemplo:
        return Semestre::find()->orderBy(['id_semestre' => SORT_DESC])->one()->id_semestre ?? null;
    }

    private function obtenerCicloActual()
    {
        // Aquí va la lógica para determinar el ciclo actual, por ejemplo:
        return CicloEscolar::find()->orderBy(['id_ciclo' => SORT_DESC])->one()->id_ciclo ?? null;
    }
}
