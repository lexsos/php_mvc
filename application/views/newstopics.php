<div class="news">
    <p class="title">Новости:</p>

    <ul class="newslist">
        <?php foreach($this->model->getLatestNews( $this->model->webApp->config->newsCountLimit ) as $news){ ?>
            <li> <a href="<?php echo $this->getReq("news/newsread/".$news->id)  ?>"> <span class="<?php if($news->old > $this->model->webApp->config->newsDayToOld) echo "date"; else echo "datetoday";  ?>">
                <?php echo $news->strdate; ?>
                </span> 
                <?php echo $news->topic; ?>  </a> 
            </li>
        <?php } ?>
    </ul>
</div>
