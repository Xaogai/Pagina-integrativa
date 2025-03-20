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
    
        if (!$user_id) {
            throw new ForbiddenHttpException('No tienes permiso para acceder a esta página.');
        }
    
        $model = Alumnos::findOne(['id_usuario' => $user_id]);
    
        if (!$model) {
            $model = new Alumnos();
            $model->id_usuario = $user_id;
        }
    
        // Verificar si el formulario fue enviado con la acción de edición
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
                $editable = false; // Deshabilitar los campos después de guardar
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
            'instituciones' => ArrayHelper::map(Institucion::find()->all(), 'id_institucion', 'nombre'),
            'semestres' => ArrayHelper::map(Semestre::find()->all(), 'id_semestre', 'nombre'),
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
}
