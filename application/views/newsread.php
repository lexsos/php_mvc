<?php
    $news = $this->model->currentData->news;
?>
<p>Дата публикации: <?php echo $news->strdate;  ?></p>
<p>Дата заголовок: <?php echo $news->topic;  ?></p>
<p>Содержание:</p>
<p><?php echo $news->content;  ?> </p>
