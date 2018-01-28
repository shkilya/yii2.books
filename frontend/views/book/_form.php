<?php

use common\helpers\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\Author;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
/* @var Author[] $authors */

$authors = Author::find()->all();
/** @var array $authorsArray */
$authorsArray = ArrayHelper::map($authors,'id',function($author_model){
    /** @var Author  $author_model */
    return  $author_model->firstname.' '.$author_model->lastname;
} );



?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'date')->textInput()->widget(DatePicker::className()) ?>

    <?= $form->field($model, 'preview')->fileInput() ?>
    <?php  if($model->preview):?>
        <?= Html::img(Image::thumb('/' . $model->preview, 200, 200), ['alt' => '']) ?>
    <?php endif;?>

    <?= $form->field($model, 'author_id')->dropDownList($authorsArray,[
            'prompt'=>Yii::t('app','Choose author')
    ] ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
