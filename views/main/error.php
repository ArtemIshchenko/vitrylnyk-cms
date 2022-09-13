<?php
use yii\helpers\Html;
use yii\helpers\Url;
$message = nl2br(Html::encode($message));
$this->title = rtrim($message, '.');
?>
<h1><?= $this->title . ' (' . $exception->statusCode . ')' ?></h1>

<div class="alert alert-danger">
    <?= $message ?>
</div>
<?php if($exception->statusCode==404) : ?>
<p>
    Возможно, эта страница была удалена либо допущена ошибка в адресе
</p>

<p>
   <a href="<?= Url::to(['/']) ?>"><?= Yii::t('app', 'Перейти на главную страницу &rarr;') ?></a>
</p>
<?php endif; ?>