<?php

namespace app\controllers\alumno;  // 🔹 Cambia el namespace para reflejar la subcarpeta

use yii\web\Controller;

class AlumnoController extends Controller
{
    public $layout = 'main_alumno'; // Usa el layout específico

    public function actionIndex()
    {
        return $this->render('/alumno/index');  // 🔹 Indica la ruta completa de la vista
    }
}

