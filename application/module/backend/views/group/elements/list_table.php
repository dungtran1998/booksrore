<?php
$xhtml = '';

// $time = time();
// echo $format = date('H:i:s d/m/Y', time());
// echo "<br>";
// echo $format_2 = date('Y/m/d H:i:s', strtotime($format));
// echo "<br>";
// echo date('H:i:s d/m/Y', strtotime($format_2));
// Có sự lẫn lộn giữa date và month khi chuyển timestamp từ format
//========================

foreach ($this->items as $key => $item) {
    $id                 = $item['id'];
    $ckb                = sprintf('<input type="checkbox" name="cid[]" value="%s">', $id);
    $name               = HelperBackend::highlight($this->arrParams['search'] ?? "", $item['name']);
    $groupACP           = HelperBackend::itemGroupACP($arrParams['module'], $arrParams['controller'], $id, $item['group_acp']);
    $status             = HelperBackend::itemStatus($arrParams['module'], $arrParams['controller'], $id, $item['status']);
    $created            = HelperBackend::itemHistory($item['created_by'], $item['created']);
    $modified           = HelperBackend::itemHistory($item['modified_by'], $item['modified']);

    $optionsBtnAction   = ['small' => true, 'circle' => true];
    $linkEdit = URL::createLink($arrParams['module'], $arrParams['controller'], 'form', ['id' => $id]);;
    $btnEdit            = HelperBackend::buttonLink($linkEdit, '<i class="fas fa-pen"></i>', 'btn-info', $optionsBtnAction);
    $linkDelete         = URL::createLink($arrParams['module'], $arrParams['controller'], 'delete', ['id' => $id]);
    $btnDelete          = HelperBackend::buttonLink($linkDelete, '<i class="fas fa-trash"></i>', 'btn-danger btn-delete', $optionsBtnAction);

    $xhtml .= '
    <tr id= "itemTr-' . $id . '">
        <td>' . $ckb . '</td>
        <td>' . $id . '</td>
        <td>' . $name . '</td>
        <td>' . $groupACP . '</td>
        <td>' . $status . '</td>
        <td>' . $created . '</td>
        <td>' . $modified . '</td>
        <td>
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
$lblGroupACP = HelperBackend::cmsLinkSort("Group ACP", "group_acp", $columnPost, $orderPost);
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
                    <th><?= $lblName ?></th>
                    <th><?= $lblGroupACP ?></th>
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