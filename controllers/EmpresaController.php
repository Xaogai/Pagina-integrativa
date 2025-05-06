<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class EmpresaController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex()
    {
        return $this->redirect(['datos-empresa']);
    }

    /**
     * Acción para crear/actualizar los datos de la empresa
     */
    public function actionDatosEmpresa()
    {
        // Verificar sesión del alumno
        $idUsuario = Yii::$app->session->get('user_id');
        if (!$idUsuario) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión primero.');
            return $this->redirect(['site/login']);
        }

        // Buscar si ya existe un registro de empresa para este alumno
        $model = Empresa::find()
            ->orderBy(['id_empresa' => SORT_DESC])
            ->one();

        if (!$model) {
            $model = new Empresa();
        }

        $model->fecha_insercion = date('Y-m-d H:i:s'); // Asignar fecha siempre

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Empresa guardada correctamente.');
            return $this->redirect(['hoja-datos/crear-hoja-datos', 'idEmpresa' => $model->id_empresa]);
        }

        // Si hay errores, mostrarlos
        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', 'Error al guardar: ' . implode(' ', $model->getFirstErrors()));
        }

        return $this->render('/empresa/datos_empresa', [
            'model' => $model,
            'editable' => Yii::$app->request->post('editable', false),
        ]);
    }

    /**
     * Acción para ver los datos de la empresa (solo lectura)
     */
    public function actionVerEmpresa()
    {
        $idUsuario = Yii::$app->session->get('user_id');
        if (!$idUsuario) {
            throw new ForbiddenHttpException('Acceso denegado. Debes iniciar sesión.');
        }

        $model = Empresa::find()
            ->orderBy(['id_empresa' => SORT_DESC])
            ->one();

        if (!$model) {
            Yii::$app->session->setFlash('info', 'No hay datos de empresa registrados.');
            return $this->redirect(['datos-empresa']);
        }

        return $this->render('/empresa/ver_empresa', [
            'model' => $model,
        ]);
    }
}