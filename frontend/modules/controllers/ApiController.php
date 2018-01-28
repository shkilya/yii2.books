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


}
