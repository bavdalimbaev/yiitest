<?php


namespace app\controllers;


use app\models\Brand;
use app\models\CarSearch;
use app\models\Drive;
use app\models\Engine;
use app\models\Model;
use Yii;
use yii\web\Controller;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->view->title = ' Продажа новых автомобилей в Санкт-Петербурге';
        $engines = Engine::find()->all();
        $drives = Drive::find()->all();

        $searchCar = new CarSearch();
        $dataProvider = $searchCar->search(Yii::$app->request->queryParams);

        return $this->render('index', compact(
            'dataProvider',
            'engines',
            'drives'
        ));
    }

    public function actionBrand($alias)
    {
        $brand = Brand::find()->where("alias = '$alias'")->one();
        Yii::$app->view->title = ' Продажа новых автомобилей ' . $brand->title . ' в Санкт-Петербурге';
        $engines = Engine::find()->all();
        $drives = Drive::find()->all();

        $searchCar = new CarSearch();
        $dataProvider = $searchCar->search(Yii::$app->request->queryParams);

        return $this->render('brand', compact(
            'dataProvider',
            'engines',
            'drives',
            'brand'
        ));
    }

    public function actionType($alias, $type)
    {
        $model = Model::find()
            ->select(['models.*', 'brands.title as brandTitle'])
            ->innerJoin('`brands`', 'brands.id = models.brand_id')
            ->asArray()
            ->where(["brands.alias" => $alias, "models.alias" => $type])
            ->one();
        Yii::$app->view->title = "Продажа новых автомобилей " . $model['brandTitle'] . " " . $model['title'] . " в Санкт-Петербурге";
        $engines = Engine::find()->all();
        $drives = Drive::find()->all();

        $searchCar = new CarSearch();
        $dataProvider = $searchCar->search(Yii::$app->request->queryParams);

        return $this->render('model', compact(
            'dataProvider',
            'engines',
            'drives',
            'model'
        ));
    }

    public function actionAjax()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $searchCar = new CarSearch();
            $dataProvider = $searchCar->search($data);

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $dataProvider->getModels(),
                'post' => $data,
                'code' => 200
            ];
        }
    }
}