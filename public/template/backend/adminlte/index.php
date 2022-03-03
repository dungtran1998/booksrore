<?php
$module = $this->arrParams["module"];
$controller = $this->arrParams["controller"];
$action = $this->arrParams["action"];
$showNavBar_SideBar = ($module == "backend" && $controller == "user" && $action == "login") ? true : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <title><?= $this->_title; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <?php echo $this->_pluginsCssFiles; ?>
    <?php echo $this->_cssFiles; ?>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php require_once 'html/navbar.php'; ?>
        <!-- Main Sidebar Container -->
        <?php require_once 'html/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php require_once 'html/page-header.php'; ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->

        <?php require_once 'html/footer.php'; ?>
    </div>
    <!-- ./wrapper -->


    <?php echo $this->_pluginsJsFiles; ?>
    <?php echo $this->_jsFiles; ?>

    <script>
        <?php
        if (isset($_SESSION["notify"])) {
            echo HelperBackend::showMessage();
        }
        ?>
    </script>

</body>

</html>