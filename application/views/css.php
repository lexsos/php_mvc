<?php foreach( $this->model->getCsss() as $css ){ ?>
<link rel="stylesheet" type="text/css" href="<?php  echo $this->getCss($css);?>">
<?php } ?>