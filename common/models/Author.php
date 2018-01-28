<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $fullName
 */
class Author extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }

    public function getFullName()
    {
        return  $this->firstname.' '.$this->lastname;
    }
}
