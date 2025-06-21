<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

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
        $idUsuario = Yii::$app->session->get('user_id');
        if (!$idUsuario) {
            Yii::$app->session->setFlash('error', 'Debes iniciar sesión primero.');
            return $this->redirect(['site/login']);
        }

        $model = Empresa::find()
            ->orderBy(['id_empresa' => SORT_DESC])
            ->one();

        if (!$model) {
            $model = new Empresa();
        }

        $model->fecha_insercion = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post())) {
            // Obtener archivo subido
            $model->logo = UploadedFile::getInstance($model, 'logo');

            if ($model->validate()) {
                // Si se subió un archivo nuevo
                if ($model->logo) {
                    $nombreArchivo = 'logo_' . time() . '.' . $model->logo->extension;
                    $ruta = Yii::getAlias('@webroot/uploads/') . $nombreArchivo;

                    if ($model->logo->saveAs($ruta)) {
                        $model->logo = 'uploads/' . $nombreArchivo;
                    }
                }

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Empresa guardada correctamente.');
                    return $this->redirect(['hoja-datos/crear-hoja-datos', 'idEmpresa' => $model->id_empresa]);
                }
            }

            Yii::$app->session->setFlash('error', 'Error al validar datos: ' . implode(' ', $model->getFirstErrors()));
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