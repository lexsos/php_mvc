<?php

$configuration = array();

$configuration["charset"] = "utf-8";

$configuration["basePath"] = "/mvc/";
$configuration["css"] = array("main.css", "login.css", "news.css", "support.css", "documents.css", "mobilephones.css");
$configuration["js"] = array("jquery.js");
$configuration["before"] = array("userauth/cheksession");
$configuration["after"] = array("userauth/userform", "css/index", "js/index", "news/topics");

$configuration["authCaseInsens"] = true;
$configuration["ldapServer"] = "avia.local";
$configuration["ldapDomain"] = "avia.local";
$configuration["ldapScope"] = "dc=avia,dc=local";
$configuration["ldapUser"] = "user";
$configuration["ldapPass"] = ".pthghjcn";
$configuration["roleAdmin"] = array("wwwadmins");

$configuration["dbHost"] = "127.0.0.1";
$configuration["dbName"] = "mvcdb";
$configuration["dbUser"] = "mvc";
$configuration["dbPass"] = "123456";

$configuration["newsCountLimit"] = 20;
$configuration["newsDayToOld"] = 2;

$configuration["docsDir"] = "/var/www/mvc/doczips";

?>