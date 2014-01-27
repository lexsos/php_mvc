<?php
    $ticket = $this->model->currentData->ticket;
    $msgs = $this->model->getMsgs( $ticket->id );
?>

<div class="support">

    <p>Создатель обращения: <?php echo $ticket->creatorfio; ?></p>
    <p>Дата создания обращения: <?php echo $ticket->strdate; ?></p>
    <p>Дата последнего сообщения: <?php echo $ticket->strmoddate; ?></p>
    <p>Заголовок: <?php echo $ticket->topic; ?></p>

    <?php foreach($msgs as $msg){ ?>
        <div class="msg <?php if( $ticket->creator_id !== $msg->creator_id ){echo "answer";}  ?>">
            <span class="date" >Дата: <?php echo $msg->strdate; ?> </span>
            <span>автор: <?php echo $msg->creatorfio; ?> </span>
            <span class="content"> <?php $this->outText( $msg->content ); ?> </span>
        </div>
    <?php } ?>

    <div class="editmsg">
        <span>Добавить сообщение:</span>
        <form action="<?php echo $this->getReq("support/addmsg/".$ticket->id) ?>" method="post">
        <textarea rows="4" cols="50" name="content" id="content"></textarea>
        <input class="submit" type="submit" value="Отправить">
        </form>
    </div>

</div>


