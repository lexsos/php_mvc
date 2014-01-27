<?php

$route = $this->model->redirectTo();
$req = $this->getReq( $route );

header('Location:' . $req );
?>