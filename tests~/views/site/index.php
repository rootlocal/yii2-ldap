<?php

use yii\web\View;

/**
 * @var View $this
 */
?>

<div class="site-index">
    <p>@assets path: <code><?= Yii::getAlias('@assets') ?></code></p>
    <p>@tests path: <code><?= Yii::getAlias('@tests') ?></code></p>
</div>