<?php
$arrParams = $this->arrParams;
$linkAddNew = URL::createLink('backend', 'group', 'form');
$btnAddNew = HelperBackend::buttonLink($linkAddNew, '<i class="fas fa-plus"></i> Add New');
$urlBulkAction = URL::createLink($arrParams['module'], $arrParams['controller'], 'value_new');
$spanBulkAction = '<span class="badge badge-pill badge-danger navbar-badge" ></span>';
$btnBulkAction = HelperBackend::buttonLink($urlBulkAction, 'Apply' . $spanBulkAction, 'btn-info btn-apply-bulk-action');


$arrBulkAction = [
    "" => "Bulk Action",
    "multiDelete" => "Delete",
    "multiActive" => "Active",
    "multiInactive" => "Inactive"
];
$slbBulkAction = HelperBackend::cmsSelectBox("bulk-action", "form-control custom-select slb-bulk-action", $arrBulkAction, "");
?>

<!-- Search & Filter -->
<?php require_once 'elements/search_filter.php' ?>
<!-- List -->
<div class="card card-outline card-info">
    <?php require_once 'elements/list_card_header.php' ?>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between mb-2">
                <div>
                    <div class="input-group">
                        <!-- <select class="form-control custom-select slb-bulk-action">
                            <option value="">Bulk Action</option>
                            <option value="multiDelete">Delete</option>
                            <option value="multiActive">Active</option>
                            <option value="multiInactive">Inactive</option>
                        </select> -->
                        <?php echo $slbBulkAction ?>
                        <span class="input-group-append">
                            <?= $btnBulkAction ?>
                        </span>
                    </div>
                </div>
                <div><?= $btnAddNew ?></div>
            </div>
        </div>
        <?php require_once 'elements/list_table.php' ?>
    </div>
    <?php require_once 'elements/list_card_footer.php' ?>
</div>