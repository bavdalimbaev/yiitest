
<li>
    <a href="
    /catalog/<?= ( isset($model['children']) )
        ? $model['alias']
        : $model['brand'] . '/' . $model['alias'];
    ?>

<?//= ( isset($model['children']) )
//            ? \yii\helpers\Url::to(['catalog/brand', 'alias' => $model['alias'] ])
//            : \yii\helpers\Url::to(['catalog/model', 'alias' => $model['brand'], 'id' => $model['alias'] ]);
//        ?>
">
        <?= $model['title'] ?>
    </a>
    <?php if ( isset($model['children']) ): ?>
        <ul>
            <?= $this->getMenuHtml($model['children']) ?>
        </ul>
    <?php endif ?>
</li>
