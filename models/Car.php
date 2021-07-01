<?php

namespace app\models;

use yii\db\ActiveRecord;

class Car extends ActiveRecord
{
    public static function tableName()
    {
        return 'cars';
    }

    public function getDrive()
    {
        return $this->hasOne(Drive::class, ['id' => 'drive_id']);
    }

    public function getEngine()
    {
        return $this->hasOne(Engine::class, ['id' => 'engine_id']);
    }

    public function getModel()
    {
        return $this->hasOne(Model::class, ['id' => 'model_id']);
    }
}
