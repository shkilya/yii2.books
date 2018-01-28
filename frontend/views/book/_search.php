<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Author;

/* @var $this yii\web\View */
/* @var $model common\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */


$authors = Author::find()->all();
/** @var array $authorsArray */
$authorsArray = ArrayHelper::map($authors,'id',function($author_model){
    /** @var Author  $author_model */
    return  $author_model->firstname.' '.$author_model->lastname;
} );


?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?php  echo $form->field($model, 'author_id')->dropDownList($authorsArray,[
                'prompt'=>''
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group row">
            <?= $form->field($model, 'date_publish_start')
                ->widget(\yii\jui\DatePicker::className())
                ->label('Дата выхода книги') ?>
            </div>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date_publish_end')
                ->widget(\yii\jui\DatePicker::className())
                ->label('до') ?>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


    <?php // echo $form->field($model, 'preview') ?>





    <?php ActiveForm::end(); ?>

</div>
