<?php

$arrParam = $this->arrParams;
$mess = "";
switch ($arrParam['type']) {
    case "register-success":
        $mess = "<i class=\"fas fa-check\"></i> your account has been created. Wait for email from the adminstration.";
        break;
    default:
        $mess = "<i class=\"fas fa-minus\"></i> Failed";
        break;
}
?>
<div class="breadcrumb-section"></div>
<div class="notice">
    <?= $mess; ?>
</div>