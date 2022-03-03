<?php
$btnSearch = HelperBackend::button('submit', 'search', 'btn-info btn-search');

$clearLink = "javascript:clearSearch('search')";
$btnClear = HelperBackend::buttonLink($clearLink, 'Clear', 'btn-danger');
$showFilterStatus = HelperBackend::showFilterStatus($this->arrParams["module"], $this->arrParams["controller"], $this->itemStatusCount, $this->arrParams["status"] ?? "all", $this->arrParams["search"] ?? "");


$inputModule = HelperBackend::cmsInput("hidden", "module", "", $this->arrParams["module"]);
$inputController = HelperBackend::cmsInput("hidden", "controller", "", $this->arrParams["controller"]);
$inputAction = HelperBackend::cmsInput("hidden", "action", "", $this->arrParams["action"]);

$searchByArr = ["all" => "Search By All", "id" => "Search By ID", "name" => "Search By Name"];
$searchBy = HelperBackend::cmsSelectBox("search_by", "search_by", $searchByArr, $this->arrParams["search_by"] ?? "all");

$inputSearch = HelperBackend::cmsInput("text", "search", "form-control", $this->arrParams["search"] ?? "");



$arrGroupACP = ["default" => "Select Group ACP", "1" => "Yes", "0" => "No"];
$keySelectGroupACP = $this->arrParams["group_acp"] ?? "default";
$slbGroupACP = HelperBackend::cmsSelectBox("group_acp", "form-control custom-select groupACP", $arrGroupACP, $keySelectGroupACP);
?>

<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">Search & Filter</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="area-filter-status mb-2">
                    <!-- <a href="#" class="btn btn-info">All <span class="badge badge-pill badge-light">8</span></a>
                    <a href="#" class="btn btn-secondary">Active <span class="badge badge-pill badge-light">3</span></a>
                    <a href="#" class="btn btn-secondary">Inactive <span class="badge badge-pill badge-light">5</span></a> -->
                    <?php echo $showFilterStatus; ?>
                </div>

                <div class="mb-2">
                    <form action="#" method="GET" id="filter-bar">
                        <?= $slbGroupACP ?>
                    </form>

                </div>

                <div class="area-search mb-2">
                    <form action="" method="GET" id="filter-search">
                        <div class="input-group">
                            <?= $inputModule . $inputController . $inputAction . $searchBy . $inputSearch; ?>
                            <span class="input-group-append">
                                <?= $btnSearch . $btnClear ?>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>