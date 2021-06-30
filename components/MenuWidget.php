<?php


namespace app\components;
use yii\base\Widget;
use app\models\Brand;
use app\models\Model;

class MenuWidget extends Widget
{

    public $tpl;
    public $data;  // массив базы данных
    public $tree;  // результат категория и подкатегория путем виджета
    public $menuHtml;  // результат html после результата категория
//    public $model;

    public function init()
    {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'brand';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        $this->data = Brand::find()
            ->indexBy('id')
            ->asArray()
            ->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);

        return $this->menuHtml;
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            $tree[$id] = &$node;
            $models = Model::find()->where("brand_id = '".$node['id']."'")->asArray()->all();
            foreach ($models as $model) {

                $this->data[$model['brand_id']]['children'][$model['id']] = $model;
                $this->data[$model['brand_id']]['children'][$model['id']]['brand'] = $node['alias'];
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree){
        $str = '';
        foreach ($tree as $model) {
            $str .= $this->modeltToTemplate($model);
        }
        return $str;
    }

    protected function modeltToTemplate($model)
    {
        ob_start();
        include __DIR__ . '/views/' . $this->tpl;
        return ob_get_clean();
    }

}

