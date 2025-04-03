<?php

namespace app\controllers;

use Yii;
use app\models\Alumnos;
use app\models\Empresa;
use app\models\HojaDatos;
use app\models\Fondo_CBT;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RegistroCartasController extends Controller
{
    public function actionHojaDatos()
    {
        $model = new HojaDatos();
    
        // Recuperar el id_alumno desde la sesión
        $session = Yii::$app->session;
        if (!$session->has('id_alumno')) {
            Yii::$app->session->setFlash('error', 'No se encontró el alumno en la sesión.');
            return $this->redirect(['site/index']);
        }
        $id_alumno = $session->get('id_alumno');
    
        // Obtener el alumno
        $alumno = Alumnos::findOne($id_alumno);
        if (!$alumno) {
            Yii::$app->session->setFlash('error', 'El alumno no existe.');
            return $this->redirect(['site/index']);
        }
    
        // Obtener la última empresa registrada
        $empresa = Empresa::find()->orderBy(['id_empresa' => SORT_DESC])->one();
        if (!$empresa) {
            Yii::$app->session->setFlash('error', 'No se encontró ninguna empresa registrada.');
            return $this->redirect(['empresa/index']);
        }
    
        // Obtener el formato CBT vigente
        $formato = Fondo_CBT::find()->where(['status' => 'VIGENTE'])->orderBy(['id_fondo' => SORT_DESC])->one();
        if (!$formato) {
            Yii::$app->session->setFlash('error', 'No se encontró un formato CBT vigente.');
            return $this->redirect(['fondo-cbt/index']);
        }
    
        // Asignar valores a la hoja de datos
        $model->id_alumno = $id_alumno;
        $model->id_empresa = $empresa->id_empresa;
        $model->status = 'EN REVISION';
        $model->id_semestre = $alumno->id_semestreactual;
        $model->id_ciclo = $alumno->id_ciclo;
        $model->id_formato = $formato->id_fondo;
        $model->fecha_emision = date('Y-m-d');
        $model->fecha_aceptacion = null;
        $model->fecha_termino = null;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Hoja de datos registrada correctamente.');
            return $this->redirect(['hoja-datos/view', 'id' => $model->id_hojadatos]);
        } else {
            Yii::$app->session->setFlash('error', 'Error al guardar la hoja de datos.');
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    }  
}
