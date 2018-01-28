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
                'format'=>'raw',
                'value'=>function($model){

                    /** @var \common\models\Book $model */

                    return  '<a data-fancybox  href="'.Image::thumb('/'.$model->preview,400,400).'" >'.
                            Html::img(Image::thumb('/'.$model->preview,200,200),['width'=>200,'height'=>200])
                        .'</a>';
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

            [

                'format'=>'raw',
                'value'=>function($model){
                    return '<a style="cursor: pointer;"><span class="glyphicon glyphicon-eye-open view-book" data-book_id="'.$model->id.'" ></span></a>' ;
                }
            ],
            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
            ['class' => 'yii\grid\ActionColumn','template'=>'{delete}'],

        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
yii\bootstrap\Modal::begin([
                               'headerOptions' => ['id' => 'modalHeader'],
                               'id' => 'BookModal',
                               'size' => 'modal-lg',
                               'closeButton' => [
                                   'id'=>'close-button',
                                   'class'=>'close',
                                   'data-dismiss' =>'modal',
                               ],
                               //keeps from closing modal with esc key or by clicking out of the modal.
                               // user must click cancel or X to close
                               'clientOptions' => [
                                   'backdrop' => false, 'keyboard' => true
                               ]
                           ]);
echo "<div id='BookModalContent'></div>";
yii\bootstrap\Modal::end();
?>