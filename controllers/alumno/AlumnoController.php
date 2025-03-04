<?php

namespace app\controllers\alumno;

use Yii;
use app\models\Alumno;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AlumnoController extends Controller
{
    public $layout = 'main_alumno';

    public function actionIndex()
    {
        return $this->render('/alumno/index');
    }

    public function actionDatosGenerales()
    {
        // Instancia un nuevo modelo de Alumno
        $model = new Alumno();

        // Si se envía el formulario y es válido, guarda y redirige
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Datos guardados correctamente.');
            return $this->redirect(['datos-generales']);
        }

        // Renderiza la vista pasando el modelo
        return $this->render('/alumno/datos-generales', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Alumno();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_alumno]);
        }

        return $this->render('/alumno/create', [
            'model' => $model,
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
        if (($model = Alumno::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El alumno no existe.');
    }
}
