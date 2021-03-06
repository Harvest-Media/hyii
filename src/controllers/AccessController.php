<?php

namespace hyii\controllers;

use Hyii;
use hyii\web\Controller;
use hyii\models\LoginForm;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class AccessController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }

    /**
     * Apps will post to this action to login
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        // The $model->load method second parameter is blank because we are not passing in a form name
        if ($model->load(Hyii::$app->request->post(),'') && $model->login()) {

            $user = Hyii::$app->user->identity;

            /**
             * Prep return data
             */
            $token = $user['authKey'];
            unset($user['authKey']);
            unset($user['password']);

            return [
                "loggedIn" => true,
                "token" => $token,
                "user" => $user,
            ];

        } else {
            return ["loggedIn" => false];
        }
    }

}
