<?php
    $crgt = $this->model->currentData->crgt;
    $crgtId = $crgt->id;
?>
<div>
  <form action="<?php echo $this->getReq("mobilephones/modcrgtype/".$crgtId); ?>" method="post">
    <fieldset>

        <legend>Редактирование типа начислений</legend>

        <label for="id">Идентификатор</label> 
        <input type="text" name="id" id="id" value="<?php echo $crgt->id; ?>">

        <br>

        <label for="description">Описание</label>
        <input type="text" name="description" id="description" value="<?php echo $crgt->description; ?>">

        <br>

        <input type="checkbox" name="active" id="active" value="1" <?php if($crgt->active) echo "checked"; ?> >
        <label for="active">Активно</label>

        <br>

        <input class="submit" type="submit" value="Сохранить">
        <a href="<?php echo $this->getReq("mobilephones/listcrgtypes"); ?>" class="link">Назад</a>
    </fieldset>
  </form>
</div>
