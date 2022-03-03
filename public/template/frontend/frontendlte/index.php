<?php
$imageURL = $this->_dirImg;
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once "html/head.php"; ?>

<body>
    <div class="loader_skeleton">
        <div class="typography_section">
            <div class="typography-box">
                <div class="typo-content loader-typo">
                    <div class="pre-loader"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- header start -->
    <?php require_once "html/header.php" ?>
    <!-- header end -->

    <!-- Content -->
    <?php require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php'; ?>


    <!-- footer -->

    <?php require_once BLOCK_PATH . "phone-ring.php" ?>

    <!-- footer end -->
    <?php require_once  "html/footer.php"; ?>


    <!-- tap to top -->
    <?php require_once BLOCK_PATH . "tap-top.php" ?>
    <!-- tap to top end -->
    <?php require_once "html/script.php"; ?>
    <script>
        <?php
        if (isset($_SESSION["notify"])) {
            echo HelperBackend::showMessage();
        }
        ?>
    </script>
</body>

</html>