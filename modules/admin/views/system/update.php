<?php
use yii\helpers\Url;

$this->title = Yii::t('app', 'Оновити');
?>
<ul class="nav nav-pills">
    <li>
        <a href="<?= Url::to(['/system']) ?>">
            <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?= Yii::t('app', 'Назад') ?>
        </a>
    </li>
</ul>
<br>

<pre>
<?= $result ?>
</pre>
