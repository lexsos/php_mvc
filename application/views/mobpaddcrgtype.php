<div>
  <form action="<?php echo $this->getReq("mobilephones/addcrgtype") ?>" method="post">
    <fieldset>
        <legend>Добавление типа платежа</legend>

        <label for="id">Идентификатор платежа</label> 
        <input type="id" name="id" id="id" value="">

        <br>

        <label for="description">Описание</label>
        <input type="text" name="description" id="description" value="">

        <br>

        <input type="checkbox" name="active" id="active" value="1">
        <label for="active">Активно</label>

        <br>

        <input class="submit" type="submit" value="Добавить">
        <a href="<?php echo $this->getReq("mobilephones/listcrgtypes"); ?>" class="link">Назад</a>
    </fieldset>
  </form>
</div>
