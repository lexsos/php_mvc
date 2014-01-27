<?php
    $users = $this->model->currentData->usersList;
?>
<div>
  <form action="<?php echo $this->getReq("mobilephones/addphone") ?>" method="post">
    <fieldset>
        <legend>Добавление мобильного телефона</legend>

        <label for="number">Телефонный номер</label> 
        <input type="text" name="number" id="number" value="">

        <br>

        <label for="description">Описание</label>
        <input type="text" name="description" id="description" value="">

        <br>

        <label for="owner_id">Владелец</label>
        <select name="owner_id" id="owner_id">
            <?php foreach($users AS $user){  ?>
              <option value="<?php echo $user->id; ?>"><?php echo $user->fio; ?></option>
            <?php } ?>
        </select>

        <br>

        <input class="submit" type="submit" value="Добавить">
        <a href="<?php echo $this->getReq("mobilephones/listphones"); ?>" class="link">Назад</a>
    </fieldset>
  </form>
</div>
