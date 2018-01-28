<?php

use common\helpers\Image;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Book */

?>
<div class="book-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
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
                'attribute'=>'preview',
                'format'=>'html',
                'value'=>function($model){

                    /** @var \common\models\Book $model */
                    return  Html::img(Image::thumb('/'.$model->preview,200,200),['width'=>200,'height'=>200]);
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

        ],
    ]) ?>

</div>
