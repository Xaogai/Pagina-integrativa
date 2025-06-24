<?php

namespace app\controllers;

use Yii;
use app\models\Alumnos;
use app\models\CartaTermino;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CartaTerminoController extends Controller
{
    public $layout = 'main_alumno';

    public function actionDatosCartaTermino()
    {
        $idUsuario = Yii::$app->session->get('user_id');
        $alumno = Alumnos::find()
            ->where(['id_usuario' => $idUsuario])
            ->one();

        $idAlumno = $alumno ? $alumno->id_alumno : null;

        if (!$idAlumno) {
            Yii::$app->session->setFlash('error', 'No se encontró la sesión del alumno.');
        }

        // Verificamos si ya existe una carta de término
        $cartaExistente = (new \yii\db\Query())
            ->from('carta_termino')
            ->where(['id_alumno' => $idAlumno])
            ->one();

        $datosAceptacion = (new \yii\db\Query())
            ->select(['fecha_inicio_servicio', 'fecha_termino_servicio'])
            ->from('carta_aceptacion')
            ->where(['id_alumno' => $idAlumno])
            ->one();

        $fechaAceptacion = $datosAceptacion['fecha_inicio_servicio'] ?? null;
        $fechaTermino = $datosAceptacion['fecha_termino_servicio'] ?? null;

        if (!$cartaExistente) {
            $insertado = Yii::$app->db->createCommand()->insert('carta_termino', [
                'id_alumno' => $idAlumno,
                'id_semestre' => $alumno->id_semestreactual,
                'id_ciclo' => $alumno->id_ciclo,
                'status' => 'EN REVISION',
                'fecha_emision' => date('Y-m-d'),
                'fecha_aceptacion' => $fechaAceptacion,
                'fecha_termino' => $fechaTermino,
                'fecha_insercion' => date('Y-m-d'),
            ])->execute();

            if ($insertado) {
                Yii::$app->session->setFlash('success', 'Carta de término registrada exitosamente.');
            } else {
                Yii::$app->session->setFlash('error', 'Error al registrar la carta de término.');
            }
        } else {
            $actualizado = Yii::$app->db->createCommand()->update('carta_termino', [
                'id_semestre' => $alumno->id_semestreactual,
                'id_ciclo' => $alumno->id_ciclo,
                'status' => 'EN REVISION',
                'fecha_emision' => date('Y-m-d'),
                'fecha_aceptacion' => $fechaAceptacion,
                'fecha_termino' => $fechaTermino,
            ], 'id_alumno = :id_alumno', [':id_alumno' => $idAlumno])->execute();

            if ($actualizado) {
                Yii::$app->session->setFlash('success', 'Carta de término actualizada exitosamente.');
            } else {
                Yii::$app->session->setFlash('error', 'Error al actualizar la carta de término.');
            }
        }

        return $this->redirect(['practicas/terminacion']);
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
