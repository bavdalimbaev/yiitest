<?php

namespace app\models;
use yii\db\ActiveRecord;


class Model extends ActiveRecord
{

    public static function tableName()
    {
        return 'models';
    }

    public function getBrand()
    {
        return $this->hasMany(Model::class, ['brand_id' => 'id']);
    }

}
