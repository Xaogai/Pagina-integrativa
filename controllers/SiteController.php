<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\authclient\ClientInterface;
use app\models\Usuarios;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index'); // Corrección aquí
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        $email = $attributes['email'];

        $usuario = Usuarios::findOne(['correo' => $email]);

        if (!$usuario) {
            Yii::$app->session->setFlash('error', 'No tienes acceso a la aplicación.');
            return $this->redirect(['site/login']);
        }

        Yii::$app->user->login($usuario);

        // Redirigir a una acción que cierre la ventana emergente
        return $this->redirect(['site/close-popup']);
    }

    public function actionClosePopup()
    {
        // Renderizar una vista que contenga el script para cerrar la ventana emergente
        return $this->render('close-popup');
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/alumno']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/alumno']);
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        if (Yii::$app->session->has('authClient')) {
            $client = Yii::$app->authClientCollection->getClient(Yii::$app->session->get('authClient'));
            $client->revokeToken();
            Yii::$app->session->remove('authClient');
        }

        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCheckAccess()
    {
        $userId = 1;
        $permission = 'manageUsers';

        if (Yii::$app->authManager->checkAccess($userId, $permission)) {
            return "✅ El usuario tiene permisos para gestionar usuarios.";
        } else {
            return "❌ El usuario NO tiene permisos.";
        }
    }
}
