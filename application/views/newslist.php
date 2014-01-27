<div class="news">
<?php if(isAdmin()){ ?>
    <a href="<?php echo $this->getReq("news/newsadd/");  ?>"> Добавить новость </a>
<?php } ?>

    <p class="title">Новости:</p>
    <ul>
        <?php foreach($this->model->getAllNews() as $news){ ?>
            <li>
                <a href="<?php echo $this->getReq("news/newsread/".$news->id);  ?>"><?php echo $news->strdate; ?> <?php echo $news->topic; ?>  </a>
                <?php if(isAdmin()){ ?> <a href="<?php echo $this->getReq("news/newsdel/".$news->id);  ?>">Удалить</a> <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>
