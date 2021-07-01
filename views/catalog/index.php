<?php

/* @var $this yii\web\View */

use app\components\MenuWidget;
use yii\bootstrap\Alert;
use yii\web\View;
use yii\widgets\LinkPager;

$this->registerCss(
    "
                .tree, .tree ul {
                    margin:0;
                    padding:0;
                    list-style:none
                }
                .tree ul {
                    margin-left:1em;
                    position:relative
                }
                .tree ul ul {
                    margin-left:.5em
                }
                .tree ul:before {
                    content:'';
                    display:block;
                    width:0;
                    position:absolute;
                    top:0;
                    bottom:0;
                    left:0;
                    border-left:1px solid
                }
                .tree li {
                    margin:0;
                    padding:0 1em;
                    line-height:2em;
                    color:#369;
                    font-weight:700;
                    position:relative
                }
                .tree ul li:before {
                    content:'';
                    display:block;
                    width:10px;
                    height:0;
                    border-top:1px solid;
                    margin-top:-1px;
                    position:absolute;
                    top:1em;
                    left:0
                }
                .tree ul li:last-child:before {
                    background:#fff;
                    height:auto;
                    top:1em;
                    bottom:0
                }
                .indicator {
                    margin-right:5px;
                }
                .tree li a {
                    text-decoration: none;
                    color:#369;
                }
                .tree li button, .tree li button:active, .tree li button:focus {
                    text-decoration: none;
                    color:#369;
                    border:none;
                    background:transparent;
                    margin:0px 0px 0px 0px;
                    padding:0px 0px 0px 0px;
                    outline: 0;
                }
        "
);


$csrf = Yii::$app->request->getCsrfToken();

$jsForStyleUl = <<< JS
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
          engine: alias,
          _csrf : '$csrf',
          drive :  drive ? drive : 0
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
          drive: alias,
          _csrf : '$csrf',
          engine :  engine ? engine : 0
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

    
    

$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass('tree');
        tree.find('li').has('ul').each(function () {
            var branch = $(this); //li with children ul
            branch.prepend(`<i class='indicator glyphicon ` + closedClass + `'></i>`);
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + ' ' + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews
$('#tree1').treed();
$('.ajax').treed();


    
JS;


$this->registerJs(
    $jsForStyleUl,
    View::POS_READY
);
?>
<div class="site-index">

    <div class="jumbotron">
        <h2><?= $this->title ?></h2>
        <div class="row">
            <div class="col-12 col-sm-4">
                <h4>Бренд > Модели</h4>
                <ul id="tree1" class="w-50">
                    <?= MenuWidget::widget(['tpl' => 'brand']) ?>
                </ul>
            </div>
            <div class="col-12 col-sm-4">
                <h4>AJAX-SORT</h4>
                <div class="row">
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
        </div>
        <hr class="my-3">

    </div>

    <div class="body-content">

        <div class="row" id="car">
            <?php
            if ($dataProvider->getTotalCount() > 0) {
                foreach ($dataProvider->getModels() as $car) : ?>
                    <div class="col-sm-3">
                        <h3><?= $car['modelTitle'] ?></h3>

                        <p><?= $car['engineTitle'] ?></p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/"><?= $car['driveTitle'] ?>
                                &raquo;</a></p>
                    </div>
                <?php
                endforeach;
            } else {
                echo Alert::widget(
                    [
                        'body' => 'ничего нет',
                        'options' => [
                            'class' => 'alert alert-danger'
                        ]
                    ]
                );
            } ?>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <?php
                echo LinkPager::widget(
                    [
                        'pagination' => $dataProvider->getPagination(),
                    ]
                );
                ?>
            </div>
        </div>

    </div>
</div>
