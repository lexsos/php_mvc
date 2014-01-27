<?php
    $users = $this->model->currentData->usersList;
    $phone = $this->model->currentData->phone;
    $phoneId = $phone->id;
?>
<div>
  <form action="<?php echo $this->getReq("mobilephones/modphone/".$phoneId); ?>" method="post">
    <fieldset>

        <legend>Редактирование мобильного телефона</legend>

        <label for="number">Телефонный номер</label> 
        <input type="text" name="number" id="number" value="<?php echo $phone->number; ?>">

        <br>

        <label for="description">Описание</label>
        <input type="text" name="description" id="description" value="<?php echo $phone->description; ?>">

        <br>

        <label for="owner_id">Владелец</label>
        <select name="owner_id" id="owner_id">
            <?php foreach($users AS $user){  ?>
              <option value="<?php echo $user->id; ?>" <?php if($phone->owner_id == $user->id) echo "selected"; ?> ><?php echo $user->fio; ?></option>
            <?php } ?>
        </select>

        <br>

        <input class="submit" type="submit" value="Сохранить">
        <a href="<?php echo $this->getReq("mobilephones/listphones"); ?>" class="link">Назад</a>
    </fieldset>
  </form>
</div>
