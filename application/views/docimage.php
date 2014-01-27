<?php

header('Content-Type:image/jpeg');
$img = $this->model->currentData->imgPage;
header('Content-Length: ' . strlen($img) );
echo $img;

?>