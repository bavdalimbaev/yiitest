<?php

namespace app\models;

use yii\db\ActiveRecord;

class Drive extends ActiveRecord
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
