<?php
    $crgts = $this->model->getAllChargeTypes();
?>
<div class="crglist">
    <form action="" method="post" id="crgtlistform">
    <table>
        <tr>
            <th></th>
            <th>Идентификатор</th>
            <th>Описание</th>
            <th>Активно</th>
        </tr>
        <?php foreach( $crgts AS $crgt ){ ?>
            <tr>
                <td><input type="checkbox" name="marked[]" value="<?php echo $crgt->id; ?>"></td>
                <td><a href="<?php echo $this->getReq("mobilephones/modcrgtype/".$crgt->id); ?>" class="link">  <?php echo $crgt->id; ?> </a></td>
                <td><?php echo $crgt->description; ?></td>
                <td><?php echo $crgt->active ? "+":"-"; ?></td>
            </tr>
        <?php } ?>

    </table>

    <input type='button' id='btnDel' value='Удалить'>
    <input type='button' id='btnAct' value='Активировать'>
    <input type='button' id='btnDeact' value='Деактивировать'>
    <a href="<?php echo $this->getReq("mobilephones/addcrgtype"); ?>" class="link">Добавить</a>

    </form>

    <script>
        crgform = document.getElementById("crgtlistform");

        document.getElementById('btnDel').onclick = function() {
            if ( confirm('Удалить выбранные типы начислений?') ){
                crgform.action = '<?php echo $this->getReq("mobilephones/delcrgtypes"); ?>';
                crgform.submit();
            }
        }
        document.getElementById('btnAct').onclick = function() {
            if ( confirm('Активировать выбранные типы начислений?') ){
                crgform.action = '<?php echo $this->getReq("mobilephones/activecrgtypes/1"); ?>';
                crgform.submit();
            }
        }
        document.getElementById('btnDeact').onclick = function() {
            if ( confirm('Деактивировать выбранные типы начислений?') ){
                crgform.action = '<?php echo $this->getReq("mobilephones/activecrgtypes/0"); ?>';
                crgform.submit();
            }
        }
    </script>
</div>