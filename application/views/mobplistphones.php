<?php
    $phones = $this->model->getAllPhones();
?>
<div>
    <form action="<?php echo $this->getReq("mobilephones/delphones") ?>" method="post" onsubmit="return confirm('Удалить выбранные записи? При этом, будет удалена вся информация связанная с данными номерами.');">
    <table>
        <tr>
            <th></th>
            <th>Номер пп</th>
            <th>Абонентский номер</th>
            <th>Владелец</th>
            <th>Описание</th>
        </tr>
        <?php $i=0; foreach( $phones AS $phone ){ ?>
            <tr>
                <td><input type="checkbox" name="marked[]" value="<?php echo $phone->id; ?>"></td>
                <td><?php echo ++$i; ?></td>
                <td> <a href="<?php echo $this->getReq("mobilephones/modphone/".$phone->id); ?>" class="link"> <?php echo $phone->number; ?></a>  </td>
                <td><?php echo $phone->owner_fio; ?></td>
                <td><?php echo $phone->description; ?></td>
            </tr>
        <?php } ?>

    </table>
    <input class="submit" type="submit" value="Удалить">
    <a href="<?php echo $this->getReq("mobilephones/addphone"); ?>" class="link">Добавить</a>
    </form>
</div>