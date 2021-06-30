<?php

namespace app\models;

class Engine extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'engines';
    }

    public function getCar()
    {
        return $this->hasMany(Car::class, ['engine_id' => 'id']);
    }
}
