<?php

namespace app\models;

class Drive extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'drives';
    }

    public function getCar()
    {
        return $this->hasMany(Car::class, ['drive_id' => 'id']);
    }
}
