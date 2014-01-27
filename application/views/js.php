<?php foreach( $this->model->getJss() as $js ){ ?>
<script src="<?php echo $this->getJs($js); ?>"></script>
<?php } ?>