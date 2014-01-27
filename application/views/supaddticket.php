<div class="support">
    <p>
        Сформулируйте возникшую проблему и опишите ее максимально конкретно.
        От этого будет зависеть качество и срорость решения проблемы.
    </p>
    <p>
        <b>Внимание:</b> перед созданием обращения перезагрузите Ваш
        компьютер <b>дважды</b> и <b>ознакомтесь</b> с инструкциями из раздела
        "документы". Возможно, данные действия решат Вашу проблему.
    </p>
    <div class="editmsg">
        <span>Добавить обращение</span>
        <form action="<?php echo $this->getReq("support/addticket"); ?>" method="post">
        <label for="topic">Заголовок</label> 
        <input type="text" name="topic" id="topic" value="">
        <br>
        <span>Содержание:</span>
        <textarea rows="4" cols="50" name="content" id="content"></textarea>
        <br>
        <br>
        <input type="checkbox" id="agreement" name="agreement" value="" onclick="setButtonEnb( checked )">
        <label for="agreement">Я перезагрузил(а) компьютер и ознакомился(ась) с инструкциями</label>
        <br>
        <br>
        <input id="subButton" class="submit" type="submit" value="Отправить">
        </form>
    </div>
    <script>
        var subButton = document.getElementById("subButton");
        subButton.disabled=true;
        function setButtonEnb( active ){
            subButton.disabled=!active;
        }
    </script>
</div>