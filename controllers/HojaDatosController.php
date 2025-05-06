<?php

namespace app\controllers;
use app\models\Fondo_CBT;
use Yii;
use app\models\HojaDatos;
use app\models\Alumnos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class HojaDatosController extends Controller
{
    public $layout = 'main_alumno';

    public function actionCrearHojaDatos($idEmpresa)
    {
        $idUsuario = Yii::$app->session->get('user_id');
        if (!$idUsuario) {
            throw new ForbiddenHttpException('Debes iniciar sesión.');
        }

        // Buscar al alumno
        $alumno = Alumnos::findOne(['id_usuario' => $idUsuario]);
        if (!$alumno) {
            throw new NotFoundHttpException('Alumno no encontrado.');
        }

        // Verificar si ya existe hoja de datos
        $hojaExistente = HojaDatos::findOne([
            'id_alumno' => $alumno->id_alumno,
            'id_empresa' => $idEmpresa
        ]);

        if ($hojaExistente) {
            return $this->redirect(['ver-hoja-datos', 'id' => $hojaExistente->id_hojadatos]);
        }

        // Obtener el formato VIGENTE
        $formatoVigente = Fondo_CBT::findOne(['status' => 'VIGENTE']);
        if (!$formatoVigente) {
            Yii::$app->session->setFlash('error', 'No hay un formato vigente configurado.');
            return $this->redirect(['empresa/datos-empresa']);
        }

        $model = new HojaDatos();
        $model->id_alumno = $alumno->id_alumno;
        $model->id_empresa = $idEmpresa;
        $model->id_ciclo = $alumno->id_ciclo;
        $model->id_semestre = $alumno->id_semestreactual;
        $model->status = 'EN REVISION';
        $model->id_formato = $formatoVigente->id_fondo; // Usar el formato vigente
        $model->fecha_emision = date('Y-m-d');
        $model->fecha_insercion = date('Y-m-d H:i:s');
        
        // Estos campos no deberían ser requeridos inicialmente
        $model->fecha_aceptacion = null;
        $model->fecha_termino = null;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Hoja de datos creada correctamente.');
            return $this->redirect(['empresa/datos-empresa', 'id' => $model->id_hojadatos]);
        } else {
            Yii::error("Errores al guardar hoja de datos: " . print_r($model->errors, true));
            Yii::$app->session->setFlash('error', 'Error al crear hoja de datos: ' . implode(', ', $model->getFirstErrors()));
            return $this->redirect(['empresa/datos-empresa']);
        }
    }
    
    public function actionVerHojaDatos($id)
    {
        $model = HojaDatos::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Hoja de datos no encontrada.');
        }
    
        return $this->render('ver-hoja-datos', [
            'model' => $model
        ]);
    }
}