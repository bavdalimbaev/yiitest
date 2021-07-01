<?php

use app\components\MenuWidget;
use yii\bootstrap\Alert;
use yii\web\View;
use yii\widgets\LinkPager;


$csrf = Yii::$app->request->getCsrfToken();
$alias = $_GET['alias'];
$type = $_GET['type'];
$jsForStyleUl =  <<< JS
$( ".sortEngine" ).click(function() {
  let alias = $( this ).data( "alias" );
  let url = window.location.href;
  
  let urlClass = new URL(url);
  const params = new URLSearchParams(urlClass.search);
  let link = urlClass.origin + urlClass.pathname;
  
  params.set('engine', alias);
  if(url.indexOf('?') + 1) {
      window.history.replaceState({}, '', window.location.pathname+'?'+params);
  } else {
      history.pushState(null, null, link + "?" + params );
  }
  
  let drive = params.get('drive')

  $.ajax({
      url: '/catalog/ajax',
      type: 'post',
      data: {          
          alias: '$alias',
          type: '$type',
          engine: alias,
          _csrf : '$csrf',
          drive :  drive ? drive : null
      },
      success: function (data) {
          if (data.result.length > 0) {
              $('#car').html("");
              $.each(data.result, function(key, value) {
                  $('#car').append("<div class='col-sm-3'>" +
                   "<h3>"+value.modelTitle+"</h3>"+
                   "<p>"+value.engineTitle+"</p>"+
                   "<p><a class='btn btn-default' href='#'>"+value.driveTitle+" &raquo;</a></p>");
              });
          }
      }
  });
});


$( ".sortDrive" ).click(function() {
  let alias = $( this ).data( "alias" );
  let url = window.location.href;
  
  let urlClass = new URL(url);
  const params = new URLSearchParams(urlClass.search);
  let link = urlClass.origin + urlClass.pathname;

  params.set('drive', alias);
  if(url.indexOf('?') + 1) {
      window.history.replaceState({}, '', window.location.pathname+'?'+params);
  } else {
      history.pushState(null, null, link + "?" + params );
  }
  let engine = params.get('engine');
  
  $.ajax({
      url: '/catalog/ajax',
      type: 'post',
      data: {
          alias: '$alias',
          type: '$type',
          drive: alias,
          _csrf : '$csrf',
          engine :  engine ? engine : null
      },
      success: function (data) {
          if (data.result.length > 0) {
              $('#car').html("");
              $.each(data.result, function(key, value) {
                  $('#car').append("<div class='col-sm-3'>" +
                   "<h3>"+value.modelTitle+"</h3>"+
                   "<p>"+value.engineTitle+"</p>"+
                   "<p><a class='btn btn-default' href='#'>"+value.driveTitle+" &raquo;</a></p>");
              });
          }
      }
  });
});
JS;

$this->registerJs(
    $jsForStyleUl,
    View::POS_READY
);
?>
<div class="site-index">

    <div class="jumbotron">
        <h2><?=$this->title?></h2>
        <div class="row">
            <div class="col-12 col-sm-4">
                <h4>Бренд > Модели</h4>
                <ul id="tree1" class="w-50">
                    <?= MenuWidget::widget(['tpl' => 'brand']) ?>
                </ul>
            </div>
            <div class="col-12 col-sm-4">
                <h4>AJAX-SORT</h4>
                <div class="col-12">
                    <ul class="ajax tree">
                        <li><a class="h5">Двигатель</a>
                            <ul>
                                <?php
                                foreach ($engines as $engine) : ?>
                                    <li class="sortEngine" data-alias="<?= $engine['alias'] ?>"
                                        data-id="<?= $engine['id'] ?>">
                                        <?= $engine['title'] ?>
                                    </li>
                                <?php
                                endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-12">
                    <ul class="ajax tree">
                        <li><a class="h5">Привод</a>
                            <ul>
                                <?php
                                foreach ($drives as $drive) : ?>
                                    <li class="sortDrive" data-alias="<?= $drive['alias'] ?>"
                                        data-id="<?= $drive['id'] ?>">
                                        <?= $drive['title'] ?>
                                    </li>
                                <?php
                                endforeach; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <hr class="my-3">
    </div>

    <div class="body-content">

        <div class="row" id="car">
            <?php
            if($dataProvider->getTotalCount()>0) {
                foreach ($dataProvider->getModels() as $car) : ?>
                    <div class="col-sm-2">
                        <h2><?=$car['modelTitle']?></h2>

                        <p><?=$car['engineTitle']?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"><?=$car['driveTitle']?> &raquo;</a></p>
                    </div>
                <?php endforeach;
            } else {
                echo Alert::widget([
                    'body' => 'ничего нет',
                    'options' => [
                        'class' => 'alert alert-danger'
                    ]
                ]);
            } ?>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php echo LinkPager::widget([
                                                 'pagination' => $dataProvider->getPagination(),
                                             ]);
                ?>
            </div>
        </div>

    </div>
</div>

