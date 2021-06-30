<?php

namespace app\models;

class Brand extends \yii\db\ActiveRecord
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