<?php

namespace frontend\modules\controllers;

use common\models\Book;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Action;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = Book::class;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::className(),
            'only' => ['create', 'update', 'delete', 'index', 'view'],
            'rules' => [
                [
                    'actions' => ['create', 'update', 'delete', 'index', 'view'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

}
