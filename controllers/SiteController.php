<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /** 
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
public function actionIndex()
{
    return $this->render(['index']);
}


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        // Si el usuario ya está logueado, redirige a la página principal
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/alumno']);// Redirige a /alumno/index
        }
    
        // Si no está logueado, procede con el proceso de login
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/alumno']);// Redirige al índice del alumno después del login exitoso
        }
    
        // Si el login falla, limpia la contraseña y vuelve a mostrar el formulario de login
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    

        /* $user = Yii::$app->user->identity;
if ($user->role === 'admin') {
    return $this->redirect(['admin/dashboard']);
} else {
    return $this->redirect(['site/index']);
}
*/
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCheckAccess()
    {
        $userId = 1; // ID del usuario que quieres verificar
        $permission = 'manageUsers'; // Permiso a verificar

        if (Yii::$app->authManager->checkAccess($userId, $permission)) {
            return "✅ El usuario tiene permisos para gestionar usuarios.";
        } else {
            return "❌ El usuario NO tiene permisos.";
        }
    }

}
