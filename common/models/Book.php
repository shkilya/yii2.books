<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property int $date_create
 * @property int $date_update
 * @property int $date
 * @property string $preview
 * @property int $author_id
 * @property Author  $author
 */
class Book extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_create', 'date_update', 'date', 'author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute'=>'date_create',
                'updatedAtAttribute'=>'date_update',
            ],

        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'date' => 'Date',
            'preview' => 'Preview',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return  $this->hasOne(Author::className(),['id'=>'author_id']);
    }
}
