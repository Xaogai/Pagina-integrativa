<?php

namespace app\controllers;

class FondoCBTController extends \yii\web\Controller
{
    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionViews()
    {
        return $this->render('views');
    }

}
