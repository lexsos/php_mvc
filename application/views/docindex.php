<p>
    В данном разделе расположены инструкции, приказы и другие нормативные документы.
    Рекомендуется с ними ознакомиться:
<p>

<?php 
    $docs = $this->model->getDocsList();
?>

<ul>
    <?php foreach( $docs as $doc ){ ?>
        <li>
            <a class="link" target="_blank" href="<?php echo $this->getReq("documents/view/".$doc->id."/1"); ?>"> <?php echo $doc->topic; ?> </a>
            <?php if(isAdmin()){ ?>
                <a class="link" href="<?php echo $this->getReq("documents/del/".$doc->id); ?>"> Удалить </a>
            <?php } ?>
        </li>
    <?php } ?>
</ul>

<?php if(isAdmin()){ ?>
    <div class="editform">
        <form action="<?php echo $this->getReq("documents/add") ?>" method="post" enctype="multipart/form-data">
        <label for="topic">Описание документа</label> 
        <br>
        <textarea rows="4" cols="50" name="topic" id="topic"></textarea>
        <br>
        <label for="file">Укажите файл zip архива</label> 
        <input type="file" name="file" id="file">
        <br>
        <br>
        <input class="submit" type="submit" value="Загрузить">
        </form>
    </div>
<?php } ?>