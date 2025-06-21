<?php

namespace app\controllers;

use Yii;
use app\models\Alumnos;
use app\models\CartaPresentacion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartaPresentacionController extends Controller
{
    public $layout = 'main_alumno';

    public function actionDatosCartaPresentacion()
    {
        $idUsuario = Yii::$app->session->get('user_id');
        $alumno = Alumnos::find()
        ->select(['id_alumno'])
        ->where(['id_usuario' => $idUsuario])
        ->one();

        $idAlumno = $alumno ? $alumno->id_alumno : null;
        //var_dump($idAlumno); exit;
        // Verificar sesión del alumno
        if (!$idAlumno) {
            Yii::$app->session->setFlash('error', 'No se encontró la sesión del alumno.');
            return $this->redirect(['site/login']);
        }

        // Buscar o crear modelo
        $model = CartaPresentacion::findOne(['id_alumno' => $idAlumno]) ?? new CartaPresentacion();

        if ($model->load(Yii::$app->request->post())) {
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
            $model->status = CartaPresentacion::STATUS_EN_REVISION;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Carta guardada exitosamente.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar: '.print_r($model->errors, true));
            }
        }

        return $this->render('practicas/presentacion');
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
