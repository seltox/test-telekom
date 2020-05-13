<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 13.05.2020
 * Time: 14:38
 */

namespace app\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{

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
}