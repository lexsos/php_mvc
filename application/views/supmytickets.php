<?php
    $webApp = TWebApp::getWebApp();
    $userId = $webApp->register->dbUser->id;
    $tikets = $this->model->getTicketsByUser( $userId );
?>

<?php if( isAdmin() ){ 
    $tickets = $this->model->getAllTickets();
?>
    <div class="support">
    Все обращения:
    <ul>
        <?php foreach( $tickets as $ticket ){ ?>
        <li>
            <a class="link" href="<?php echo $this->getReq("support/ticket/".$ticket->id);  ?>">
            <?php echo $ticket->strmoddate;  ?>
            <?php echo $ticket->creatorfio;  ?>
            <?php echo $ticket->topic;  ?>
            </a>
        </li>
        <?php } ?>
    </ul>
    </div>
<?php } ?>

<div class="support">
    Ваши обращения:
    <ul>
        <?php foreach( $tikets as $tiket  ){ ?>
        <li> <a class="link" href="<?php echo $this->getReq("support/ticket/".$tiket->id);  ?>">
            <?php echo $tiket->strmoddate;  ?>
            <?php echo $tiket->topic;  ?>
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
