<?php

namespace app\controllers;

use Yii;
use app\models\Alumnos;
use app\models\CartaAceptacion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartaAceptacionController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex()
    {
        // Si solo quieres que /cartaaceptacion/index muestre el formulario
        return $this->redirect(['datos-carta-aceptacion']);
    }

    public function actionDatosCartaAceptacion()
    {
        // Verificar sesión del alumno
        $idAlumno = Yii::$app->session->get('user_id');
        if (!$idAlumno) {
            Yii::$app->session->setFlash('error', 'No se encontró la sesión del alumno.');
            return $this->redirect(['site/login']);
        }

        // Buscar o crear modelo
        $model = CartaAceptacion::findOne(['id_alumno' => $idAlumno]) ?? new CartaAceptacion();
        $editable = Yii::$app->request->post('editable', '0') === '1';

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('accion') === 'aceptar') {
            // Obtener datos del alumno
            $alumno = Alumnos::findOne($idAlumno);
            if (!$alumno) {
                Yii::$app->session->setFlash('error', 'Alumno no encontrado.');
                return $this->refresh();
            }

            // Asignar valores automáticos
            $model->id_alumno = $alumno->id_alumno;
            $model->id_semestre = $alumno->id_semestreactual;
            $model->id_ciclo = $alumno->id_ciclo;
            $model->status = CartaAceptacion::STATUS_EN_REVISION;
            $model->fecha_emision = date('Y-m-d');
            $model->fecha_inicio_servicio = date('Y-m-d');
            
            // Si no se proporcionó fecha_termino_servicio, usar fecha_termino + 1 día
            if (empty($model->fecha_termino_servicio)) {
                $model->fecha_termino_servicio = $model->fecha_termino;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Carta guardada exitosamente.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar: '.print_r($model->errors, true));
            }
        }

        return $this->render('datos-carta-aceptacion', [
            'model' => $model,
            'editable' => $editable,
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
