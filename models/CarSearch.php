<?php

namespace app\models;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CarSearch extends Car
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['model_id', 'engine_id', 'drive_id'], 'required'],
            [['model_id', 'engine_id', 'drive_id'], 'integer'],
            [['drive_id'], 'exist', 'skipOnError' => true, 'targetClass' => Drive::class, 'targetAttribute' => ['drive_id' => 'id']],
            [['engine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Engine::class, 'targetAttribute' => ['engine_id' => 'id']],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Model::class, 'targetAttribute' => ['model_id' => 'id']],
        ]);

    }

    public function search($params) {

        $query = ( isset($params['type']) )
            ? Car::find()
                ->select(['models.title as modelTitle', 'engines.title as engineTitle', 'drives.title as driveTitle'])
                ->innerJoin('`engines`', 'engines.id = cars.engine_id')
                ->innerJoin('`drives`', 'drives.id = cars.drive_id')
                ->innerJoin('`models`', 'models.id = cars.model_id')
                ->asArray()
                ->where("models.alias = '" . $params['type'] . "'")
            : ( (isset($params['alias']))
                ? Car::find()
                    ->select(['models.title as modelTitle', 'engines.title as engineTitle', 'drives.title as driveTitle'])
                    ->innerJoin('`engines`', 'engines.id = cars.engine_id')
                    ->innerJoin('`drives`', 'drives.id = cars.drive_id')
                    ->innerJoin('`models`', 'models.id = cars.model_id')
                    ->innerJoin('`brands`', 'brands.id = models.brand_id')
                    ->asArray()
                    ->where("brands.alias = '" . $params['alias'] . "'")
                : Car::find()
                    ->select(['models.title as modelTitle', 'engines.title as engineTitle', 'drives.title as driveTitle'])
                    ->innerJoin('`engines`', 'engines.id = cars.engine_id')
                    ->innerJoin('`drives`', 'drives.id = cars.drive_id')
                    ->innerJoin('`models`', 'models.id = cars.model_id')
                    ->asArray() );


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' => [
                'pageSize' => ( isset($params['type']) )
                    ? 3
                    : ( (isset($params['alias']))
                        ? 6
                        : 8 ),
            ]
        ]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

//        $query->filterWhere(['engines.id' => $this->engine_id]);
//        $query->andfilterWhere(['drives.id' => $this->drive_id]);

        return $dataProvider;

    }

}