<?php

namespace app\controllers\vinculacion;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

class VinculacionController extends Controller
{
    public $layout = 'main_vinculacion';

    public function actionIndex()
    {
        return $this->render('/vinculacion/index');
    }

    public function actionView()
    {
        return $this->render('/vinculacion/view', [

        ]);
    }
}
