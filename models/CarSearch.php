<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CarSearch extends Car
{
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['model_id', 'engine_id', 'drive_id'], 'required'],
                [['model_id', 'engine_id', 'drive_id'], 'integer'],
                [
                    ['drive_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Drive::class,
                    'targetAttribute' => ['drive_id' => 'id']
                ],
                [
                    ['engine_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Engine::class,
                    'targetAttribute' => ['engine_id' => 'id']
                ],
                [
                    ['model_id'],
                    'exist',
                    'skipOnError' => true,
                    'targetClass' => Model::class,
                    'targetAttribute' => ['model_id' => 'id']
                ],
            ]
        );
    }

    public function search($params)
    {
        $type = !empty($params['type']) ? htmlspecialchars($params['type']): NULL;
        $alias = !empty($params['alias']) ? htmlspecialchars($params['alias']): NULL;
        $engine = !empty($params['engine']) ? htmlspecialchars($params['engine']): NULL;
        $drive = !empty($params['drive']) ? htmlspecialchars($params['drive']): NULL;

        $query = Car::find()
            ->select([
                'cars.id', 'models.title as modelTitle', 'engines.title as engineTitle', 'drives.title as driveTitle',
            ])
            ->innerJoin('`engines`', 'engines.id = cars.engine_id')
            ->innerJoin('`drives`', 'drives.id = cars.drive_id')
            ->innerJoin('`models`', 'models.id = cars.model_id')
            ->asArray();

        (!empty($params['type']))
            ? $query
            ->where("models.alias = '" . $type . "'")
//            ->innerJoin('`brands`', 'brands.id = models.brand_id')
//            ->andWhere("brands.alias = '" . $alias . "'")
            : ((!empty($params['alias']))
            ? $query
                ->innerJoin('`brands`', 'brands.id = models.brand_id')
                ->andWhere("brands.alias = '" . $alias . "'")
            : '');

        ( !empty($params['engine']) && !empty($params['drive']) )
            ? $query->andWhere(["engines.alias" => $engine, "drives.alias" => $drive])
            : ( (!empty($params['engine']))
                ? $query->andWhere("engines.alias = '" . $engine . "'")
                : ( (!empty($params['drive']) )
                    ? $query->andWhere("drives.alias = '" . $drive . "'")
                    : ''));

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'Pagination' => [
                    'pageSize' => 6
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

}