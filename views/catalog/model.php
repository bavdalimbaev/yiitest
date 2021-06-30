<?php

use yii\widgets\LinkPager;

?>
<div class="site-index">

    <div class="jumbotron">
        <ul id="tree1">

            <?= \app\components\MenuWidget::widget(['tpl' => 'brand']) ?>
        </ul>
        <hr class="my-3">
    </div>

    <div class="body-content">

        <div class="row">
            <?php
            if($dataProvider->getTotalCount()>0) {
                foreach ($dataProvider->getModels() as $car) : ?>
                    <div class="col-lg-2">
                        <h2><?=$car['modelTitle']?></h2>

                        <p><?=$car['engineTitle']?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"><?=$car['driveTitle']?> &raquo;</a></p>
                    </div>
                <?php endforeach;
            } else {
                echo \yii\bootstrap\Alert::widget([
                    'body' => 'ничего нет',
                    'options' => [
                        'class' => 'alert alert-danger'
                    ]
                ]);
            } ?>

            <div class="col-lg-12">
                <?php echo LinkPager::widget([
                    'pagination' => $dataProvider->getPagination(),
                ]);
                ?>
            </div>

        </div>

    </div>
</div>

