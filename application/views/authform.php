<div class="loginpanel">
  <p>Авторизация</p>
  <?php if( $this->model->webApp->register->ldapUser->authState == AuthState::failAuth ){  ?> Не удалось авторизовать пользователя. Повторите попытку. <?php } ?>
  <form action="<?php echo $this->getReq("userauth/auth") ?>" method="post">
    <label for="username">пользователь</label> 
    <input type="text" name="username" id="username" value="">
    <label for="passwd">пароль</label> 
    <input type="password" name="passwd" id="passwd" value="">
    <input class="submit" type="submit" value="вход">
  </form>
</div>

