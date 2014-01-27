<!DOCTYPE html>
<html>

<head>
  <?php echo $this->renderPlace("cssPart"); ?>
  <?php echo $this->renderPlace("jsPart"); ?>
  <meta charset="utf-8">
  <title>оао вап</title>
</head>

<body>

<div class="maincontaner">

<!--

<script>
$(".maincontaner").fadeTo(0,0);
$(".maincontaner").fadeTo(1000,1);
</script>

-->

  <div class="toptitle"> <img src="<?php echo $this->getImg("logo.gif");?>"> <span class="sitetitle">Вологодское авиационное предприятие</span> </div>

  <div class="topmenu">
    <ul class="topreflist">
      <li><a href="<?php echo $this->getReq(""); ?>">Главная</a></li>
      <li><a href="<?php echo $this->getReq("news/newslist"); ?>">Новости</a></li>
<!--      <li><a href="<?php echo $this->getReq("mobilephones"); ?>">Мобильная связь</a></li> -->
      <li><a href="<?php echo $this->getReq("support"); ?>">Тех. поддержка</a></li>
      <li><a href="<?php echo $this->getReq("documents"); ?>">Документы</a></li>
    </ul>
  </div>

  <div class="mainpart">

    <div class="leftside">
      <ul class="leftreflist">
        <li><a href="<?php echo $this->getReq(""); ?>">Главная</a></li>
        <li><a href="<?php echo $this->getReq("news/newslist"); ?>">Новости</a></li>
<!--        <li><a href="<?php echo $this->getReq("mobilephones"); ?>">Мобильная связь</a></li> -->
        <li><a href="<?php echo $this->getReq("support"); ?>">Тех. поддержка</a></li>
        <li><a href="<?php echo $this->getReq("documents"); ?>">Документы</a></li>
      </ul>
    </div>

    <div class="rightside">
        <?php echo $this->renderPlace("rightPart"); ?>
    </div>

    <div class="maincontent">
        <?php echo $this->renderPlace("mainPart"); ?>
    </div>

    <div class="maincontanerdownpad"></div>
  </div>

  <div class="down">ОАО "Вологодское авиационное предприятие"</div>
  <div class="downpad"></div>
</div>

<!--

<div class="loading">
  <img src="loading.gif" align="middle">
  <span>Загрузка...</span>
</div>

-->

</body>
</html>
