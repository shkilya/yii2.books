<?php

use common\helpers\Image;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'preview',
                'format'=>'html',
                'value'=>function($model){

                    /** @var \common\models\Book $model */
                    return  Html::img(Image::thumb('/'.$model->preview,200,200),['width'=>200,'height'=>200]);
                }
            ],
            [
                'attribute'=>'date_create',
                'format'=>'raw',
                'value'=>function($model){
                    /** @var \common\models\Book $model */
                    return Yii::$app->formatter->asDatetime( $model->date_create,'dd-MM-YYYY');
                }
            ],
            [
                'attribute'=>'date_update',
                'format'=>'raw',
                'value'=>function($model){
                    /** @var \common\models\Book $model */
                    return Yii::$app->formatter->asDatetime( $model->date_update,'dd-MM-YYYY');
                }
            ],
            [
                'attribute'=>'date',
                'format'=>'raw',
                'value'=>function($model){
                    /** @var \common\models\Book $model */
                    return Yii::$app->formatter->asDatetime( $model->date,'dd-MM-YYYY');
                }
            ],
            [
                'attribute'=>'author_id',
                'format'=>'raw',
                'value'=>function($model){

                    /** @var \common\models\Book $model */
                    return $model->author->fullName;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
