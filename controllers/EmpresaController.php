<?php

namespace app\controllers;

use Yii;
use app\models\Alumnos;
use app\models\Empresa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmpresaController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex()
    {
        return $this->render('empresa/datos_empresa');
    }

    public function actionDatosEmpresa()
{
    // Buscar la primera empresa registrada (ajustar según tu lógica)
    $model = Empresa::find()->orderBy(['id_empresa' => SORT_DESC])->one();

    // Si no existe, crear una nueva
    if (!$model) {
        $model = new Empresa();
    }

    // Verificar si el formulario fue enviado con la acción de edición
    $editable = Yii::$app->request->post('editable') == '1';

    if ($model->load(Yii::$app->request->post())) {
        $accion = Yii::$app->request->post('accion');

        if ($accion === 'aceptar') {
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Datos de la empresa guardados correctamente.');

                // ❗ En lugar de redireccionar, simplemente cambiamos a modo solo lectura
                $editable = false;
            } else {
                Yii::$app->session->setFlash('error', 'Error al guardar los datos.');
            }
        }
    }

    return $this->render('/empresa/datos_empresa', [
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
