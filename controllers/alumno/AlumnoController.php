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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class AlumnoController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex()
    {
        return $this->render('/alumno/index');
    }

    public function actionDatosGenerales()
    {
        $user_id = Yii::$app->session->get('user_id');
        //$auth_token = Yii::$app->session->get('auth_token');

        echo $user_id;
        //echo $auth_token . "fffffffffffffff";

        $id = Yii::$app->user->identity->id_alumno ?? null;
        $model = $id ? $this->findModel($id) : new Alumnos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Datos guardados correctamente.');
            return $this->redirect(['datos-generales']);
        }

        return $this->render('/alumno/datos-generales', [
            'model' => $model,
            'semestres' => ArrayHelper::map(Semestre::getAllRecords(), 'id_semestre', 'nombre'),
            'instituciones' => ArrayHelper::map(Institucion::getAllRecords(), 'id_institucion', 'nombre'),
            'grados' => ArrayHelper::map(Grado::getAllRecords(), 'id_grado', 'nombre'),
            'grupos' => ArrayHelper::map(Grupos::getAllRecords(), 'id_grupo', 'nombre'),
            'carreras' => ArrayHelper::map(Carrera::getAllRecords(), 'id_carrera', 'nombre'),
            'turnos' => ArrayHelper::map(Turnos::getAllRecords(), 'id_turno', 'nombre'),
            'ciclos' => ArrayHelper::map(CicloEscolar::getAllRecords(), 'id_ciclo', 'ciclo'),
        ]);
    }

    public function actionCreate()
    {
        $model = new Alumnos();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Alumno registrado correctamente.');
                return $this->redirect(['view', 'id' => $model->id_alumno]);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo registrar el alumno.');
            }
        }

        return $this->render('/alumno/create', [
            'model' => $model,
            'instituciones' => ArrayHelper::map(Institucion::getAllRecords(), 'id_institucion', 'nombre'),
            'semestres' => ArrayHelper::map(Semestre::getAllRecords(), 'id_semestre', 'nombre'),
            'grados' => ArrayHelper::map(Grado::getAllRecords(), 'id_grado', 'nombre'),
            'grupos' => ArrayHelper::map(Grupos::getAllRecords(), 'id_grupo', 'nombre'),
            'carreras' => ArrayHelper::map(Carrera::getAllRecords(), 'id_carrera', 'nombre'),
            'turnos' => ArrayHelper::map(Turnos::getAllRecords(), 'id_turno', 'nombre'),
            'ciclos' => ArrayHelper::map(CicloEscolar::getAllRecords(), 'id_ciclo', 'ciclo'),
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
            ->with(['semestre', 'institucion']) // Cargar relaciones
            ->where(['id_alumno' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El alumno no existe.');
    }
}