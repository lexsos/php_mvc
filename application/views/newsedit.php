<div>
  <p>Редактирование новости</p>
  <form action="<?php echo $this->getReq("news/newsadd") ?>" method="post">
    <label for="topic">Заголовок</label> 
    <input type="text" name="topic" id="topic" value="">
    <br>
    <p>Содержание:</p>
    <textarea rows="4" cols="50" name="content" id="content"></textarea>
    <input class="submit" type="submit" value="Сохранить">
  </form>
</div>
