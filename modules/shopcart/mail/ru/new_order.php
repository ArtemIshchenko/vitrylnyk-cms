<?php
use yii\helpers\Html;

$this->title = $subject;
?>

<p>Создан новый заказ <b>#<?= $order->id ?></b>.</p>
<p>Просмотреть его вы можете <?= Html::a('здесь', $link) ?>.</p>
<hr>
<p>Это автоматическое сообщение и на него не нужно отвечать.</p>