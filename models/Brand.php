<?php

namespace app\models;

use yii\db\ActiveRecord;

class Brand extends ActiveRecord
{

    public static function tableName()
    {
        return 'brands';
    }

    public function getModel()
    {
        return $this->hasMany(Model::class, ['brand_id' => 'id']);
    }
}