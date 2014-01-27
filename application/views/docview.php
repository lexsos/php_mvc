<?php
    $doc = $this->model->currentData->doc;
    $docId = $doc->id;
    $pageNum = $this->model->currentData->pageNum;
    $pageCount = $doc->pageCount();

    $lastPage = false;
    $firstPage = false;

    if($pageNum <= 1){
        $priorLink = $this->getReq("documents/view/".$docId."/".($pageNum));
        $firstPage = true;
    }
    else
        $priorLink = $this->getReq("documents/view/".$docId."/".($pageNum-1));

    if($pageNum >= $pageCount){
        $nextLink = $this->getReq("documents/view/".$docId."/".($pageNum));
        $lastPage = true;
    }
    else
        $nextLink = $this->getReq("documents/view/".$docId."/".($pageNum+1)); 
?>
<!DOCTYPE html>
<html>

<head>
  <?php echo $this->renderPlace("cssPart"); ?>
  <?php echo $this->renderPlace("jsPart"); ?>
  <meta charset="utf-8">
  <title>оао вап</title>
</head>

<body>
<div class="documents">

    <?php include('docvcontrols.php'); ?>
    <div class="imgpanel"><img class="pageimg" src="<?php echo  $this->getReq("documents/image/".$docId."/".$pageNum); ?>" ></div>
    <?php include('docvcontrols.php'); ?>

    <div class="downpad"></div>
</div>

</body>
</html>
