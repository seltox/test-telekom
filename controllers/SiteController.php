<?php

namespace app\controllers;

use app\models\NotificationsForm;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\LoginForm;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'notifications', 'index', 'profile'],
                        'roles' => ['@'],
                    ],
                ],
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
        $this->redirect(array('news/index'));
    }

    public function actionNotifications() {
        $users = Users::find()->all();
        $model = new NotificationsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $users = Users::findAll($model->users);

            Yii::$app->session->setFlash('FormSubmitted');
            Yii::$app->notifications->send($users, $model->subject, $model->text);
        }

        return $this->render('notifications', array('users' => $users, 'model' => $model));
    }

    public function actionProfile() {
        $model = Users::findOne(Yii::$app->user->id);
        $model->setScenario('profile');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(array('site/profile'));
        }

        return $this->render('profile', array(
            'model' => $model
        ));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           $this->redirect(array('news/index'));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister() {
        $model = new Users();
        $model->setScenario('register');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->redirect(array('site/login'));
        }

        return $this->render('register', array(
            'model' => $model
        ));
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


}
