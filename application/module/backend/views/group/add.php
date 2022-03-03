<?php
$module = $this->arrParams["module"];
$controller = $this->arrParams["controller"];
$action = $this->arrParams["action"];

$inputName = HelperBackend::cmsInput("text", "form[name]", "form-control", $this->arrParams["form"]["name"] ?? "");
$cmsRowName = HelperBackend::cmsRowInput("name", $inputName);

$arrGroupACP  = ["default" => "- Select Group ACP", "1" => "Active", "0" => "Inactive"];
$slbGroupACP = HelperBackend::cmsSelectBox("form[group_acp]", "custom-select", $arrGroupACP, $this->arrParams["form"]["group_acp"] ?? "default");
$cmsRowGroupACP = HelperBackend::cmsRowInput("group ACP", $slbGroupACP);

$arrStatus  = ["default" => "- Select Status", "active" => "Active", "inactive" => "Inactive"];
$slbStatus = HelperBackend::cmsSelectBox("form[status]", "custom-select", $arrStatus, $this->arrParams["form"]["status"] ?? "default");
$cmsRowStatus = HelperBackend::cmsRowInput("status", $slbStatus);

$inputToken = HelperBackend::cmsInput("hidden", "form[token]", "", time());
$inputType = HelperBackend::cmsInput("hidden", "form[type]", "input-type-hidden");

$buttonSave = HelperBackend::cmsButtonLink("Save", "btn-success", "button", "", "save");
$buttonSaveNew = HelperBackend::cmsButtonLink("Save & New", "btn-success", "button", "", "save-new");
$buttonSaveClose = HelperBackend::cmsButtonLink("Save & Close", "btn-success", "button", "", "save-close");
$buttonCancel = HelperBackend::cmsButtonLink("Cancel", "btn-danger", "link", URL::createLink($module, $controller, "index"));

if (isset($this->arrParams["id"])) {
    $inputID = HelperBackend::cmsInput("text", "id", "form-control", $this->arrParams["id"], true);
    $cmsRowID = HelperBackend::cmsRowInput("iD", $inputID);
}

$error = $this->error ?? "";
?>

<!-- <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
    <ul class="list-unstyled mb-0">
        <li class="text-white"><b>Name:</b> Giá trị này không được rỗng!</li>
        <li class="text-white"><b>Group ACP:</b> Vui lòng chọn giá trị</li>
        <li class="text-white"><b>Status:</b> Vui lòng chọn giá trị!</li>
    </ul>
</div> -->
<?php echo $error; ?>

<form action="" method="POST" id="form-submit">
    <div class="card card-outline card-info">
        <div class="card-body">
            <?php echo $cmsRowName . $cmsRowGroupACP . $cmsRowStatus . $inputToken . $inputType . ($cmsRowID ?? ""); ?>
        </div>
        <div class="card-footer">
            <!-- <button type="submit" class="btn btn-success">Save</button>
            <a href="group-list.php" class="btn btn-danger">Cancel</a> -->
            <?php echo $buttonSave . $buttonSaveNew . $buttonSaveClose . $buttonCancel ?>
        </div>
    </div>
</form>