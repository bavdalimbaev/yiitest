<?php

namespace app\models;

use yii\db\ActiveRecord;

class Engine extends ActiveRecord
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
