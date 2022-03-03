<?php
// $link = "index.php?module=" . $this->arrParams["module"] . "&controller=" . $this->arrParams["controller"] . "&action=" . $this->arrParams["action"] . "";
$link = HelperBackend::createLinkParameter();
$paginationHTML = $this->pagination->showPagination($link);

?>


<div class="card-footer clearfix">
    <ul class="pagination m-0 float-right">
        <?php echo $paginationHTML ?>
        <!-- <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li> -->
    </ul>
</div>