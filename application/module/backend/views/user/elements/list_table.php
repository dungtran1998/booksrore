<?php
$xhtml = '';

foreach ($this->items as $key => $item) {
    $id                 = $item['id'];
    $ckb                = sprintf('<input type="checkbox" name="cid[]" value="%s">', $id);
    $username           = HelperBackend::highlight($this->arrParams['search'] ?? "", $item['username']);

    $linkGroupName = URL::createLink($arrParams['module'], $arrParams['controller'], 'changeGroupName', ['id' => $id, 'group_id' => "group_value"]);
    $inputGroupLink = HelperBackend::cmsInput('hidden', 'group-name',  'group-name-hidden-' . $id, $linkGroupName);
    $group = HelperBackend::cmsSelectBox('group_id', 'form-control custom-select w-auto slb-group-user', $this->groupList, $item['group_id'], 'id ="group-name-' . $id . '" data-id = "' . $id . '"') . $inputGroupLink;



    $status             = HelperBackend::itemStatus($arrParams['module'], $arrParams['controller'], $id, $item['status']);
    $created            = HelperBackend::itemHistory($item['created_by'], $item['created'], false);
    $modified           = HelperBackend::itemHistory($item['modified_by'], $item['modified'], false);

    $optionsBtnAction   = ['small' => true, 'circle' => true];
    $linkEdit = URL::createLink($arrParams['module'], $arrParams['controller'], 'form', ['id' => $id]);;
    $btnEdit            = HelperBackend::buttonLink($linkEdit, '<i class="fas fa-pen"></i>', 'btn-info', $optionsBtnAction);

    $linkDelete         = URL::createLink($arrParams['module'], $arrParams['controller'], 'delete', ['id' => $id]);
    $btnDelete          = HelperBackend::buttonLink($linkDelete, '<i class="fas fa-trash"></i>', 'btn-danger btn-delete', $optionsBtnAction);

    $generateLink = URL::createLink($arrParams['module'], $arrParams['controller'], 'delete', ['id' => $id]);
    $btnGenerate          = HelperBackend::buttonLink($generateLink, '<i class="fas fa-key"></i>', 'btn-secondary btn-generate', $optionsBtnAction);

    $xhtml .= '
    <tr id= "itemTr-' . $id . '">
        <td>' . $ckb . '</td>
        <td>' . $id . '</td>
        <td class="text-left info-user">
            <p class="mb-0">Username: ' . $username . '</p>
            <p class="mb-0">FullName:' . $item['fullname'] . '</p>
            <p class="mb-0">Email: ' . $item['email'] . '</p>
       
        </td>
        <td>' . $group . '</td>
        <td>' . $status . '</td>
        <td>' . $created . '</td>
        <td>' . $modified . '</td>
        <td>
            ' . $btnGenerate   . '
            ' . $btnEdit . '
            ' . $btnDelete . '
        </td>
    </tr>
    ';
}
$columnPost = $this->arrParams["filter_column"] ?? "";
$orderPost = $this->arrParams["filter_column_dir"] ?? "";
$lblId = HelperBackend::cmsLinkSort("ID", "id", $columnPost, $orderPost);
$lblName = HelperBackend::cmsLinkSort("Name", "name", $columnPost, $orderPost);
$lblGroup = HelperBackend::cmsLinkSort("Group", "group_id", $columnPost, $orderPost);
$lblStatus = HelperBackend::cmsLinkSort("Status", "status", $columnPost, $orderPost);
$lblCreate = HelperBackend::cmsLinkSort("Created", "created", $columnPost, $orderPost);
$lblModified = HelperBackend::cmsLinkSort("Modified", "modified", $columnPost, $orderPost);
?>

<form action="" method="post" id="table-form">
    <div class="table-responsive">
        <table class="table align-middle text-center table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="check-all-cid"></th>
                    <th><?= $lblId ?></th>
                    <th class="text-left">Info</th>
                    <th><?= $lblGroup ?></th>
                    <th><?= $lblStatus ?></th>
                    <th><?= $lblCreate ?></th>
                    <th><?= $lblModified ?></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?= $xhtml ?>
            </tbody>
        </table>
        <div>
            <input type="hidden" name="filter_column" value="name">
            <input type="hidden" name="filter_column_dir" value="<?= $orderPost ?>">
        </div>
    </div>
</form>

<!-- 
<div class="table-responsive">
    <table class="table align-middle text-center table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>ID</th>
                <th class="text-left">Info</th>
                <th>Group</th>
                <th>Status</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox"></td>
                <td>1</td>
                <td class="text-left">
                    <p class="mb-0">Username: admin01</p>
                    <p class="mb-0">FullName: Nguyễn Văn A</p>
                    <p class="mb-0">Email: admin01@example.com</p>
                </td>
                <td>
                    <select class="form-control custom-select w-auto">
                        <option> - Select Group - </option>
                        <option selected>Admin</option>
                        <option>Manager</option>
                        <option>Member</option>
                        <option>Register</option>
                    </select>
                </td>
                <td>
                    <a href="#" class="btn btn-success rounded-circle btn-sm"><i class="fas fa-check"></i></a>
                </td>
                <td>
                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                </td>
                <td>
                    <p class="mb-0"><i class="far fa-user"></i> admin</p>
                    <p class="mb-0"><i class="far fa-clock"></i> 09/01/2021</p>
                </td>
                <td>
                    <a href="#" class="btn btn-secondary btn-sm rounded-circle"><i class="fas fa-key"></i></a>
                    <a href="#" class="btn btn-info btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                    <a href="#" class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash "></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div> -->