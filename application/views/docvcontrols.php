<div class="controlpanel">
    <ul class="topreflist">
        <li><a href="<?php echo $priorLink; ?>"><span class="<?php if($firstPage) echo "inactive";?>">Предыдущая страница</span></a></li>
        <li><a href="<?php echo $nextLink; ?>"><span class="<?php if($lastPage) echo "inactive";?>">Следующая страница</span></a></li>
        <li><a href="javascript:window.close()">Закрыть документ</a></li>
    </ul>
</div>

<div class="controlpanel"> Страница <?php echo $pageNum; ?> из <?php echo $pageCount; ?>  </div>

