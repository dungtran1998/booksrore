<?php
$module = $this->arrParams["module"];
$controller = $this->arrParams["controller"];
$action = $this->arrParams["action"];
$data = $this->arrParams["form"] ?? [];
// username
$inputUserName = HelperBackend::cmsInput("text", "form[username]", "form-control", $data["username"] ?? "");
$cmsRowUserName = HelperBackend::cmsRowInput("username", $inputUserName);
// email
$inputEmail = HelperBackend::cmsInput("text", "form[email]", "form-control", $data["email"] ?? "");
$cmsRowEmail = HelperBackend::cmsRowInput("email", $inputEmail);
// Full Name
$inputFullName = HelperBackend::cmsInput("text", "form[fullname]", "form-control", $data["fullname"] ?? "");
$cmsRowFullName = HelperBackend::cmsRowInput("fullname", $inputFullName);

// Status
$arrStatus  = ["default" => "- Select Status", "active" => "Active", "inactive" => "Inactive"];
// $arrStatus  = ["default" => "- Select Status", "1" => "Active", "0" => "Inactive"];
$slbStatus = HelperBackend::cmsSelectBox("form[status]", "custom-select", $arrStatus, $data["status"] ?? "default");
$cmsRowStatus = HelperBackend::cmsRowInput("status", $slbStatus);

// Group
$arrGroup  = ["default" => "- Select Group", "1" => "Active", "0" => "Inactive"];
$slbGroup = HelperBackend::cmsSelectBox('form[group_id]', 'custom-select', $this->groupList, $data['group_id'] ?? "");
$cmsRowGroup = HelperBackend::cmsRowInput("group", $slbGroup);

// Ordering
$inputOrdering = HelperBackend::cmsInput("number", "form[ordering]", "form-control", $data["ordering"] ?? "", false, ' min = "0"');
$cmsRowOrdering = HelperBackend::cmsRowInput("ordering", $inputOrdering);




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

<?php echo $error; ?>

<form action="" method="POST" id="form-submit">
    <div class="card card-outline card-info">
        <div class="card-body">
            <?php echo $cmsRowUserName . $cmsRowEmail . $cmsRowFullName  . $cmsRowStatus . $cmsRowOrdering . $inputToken . $inputType . $cmsRowGroup . ($cmsRowID ?? ""); ?>
        </div>
        <div class="card-footer">
            <?php echo $buttonSave . $buttonSaveNew . $buttonSaveClose . $buttonCancel ?>
        </div>
    </div>
</form>