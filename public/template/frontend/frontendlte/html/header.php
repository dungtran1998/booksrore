<?php
// index.php?module=frontend&controller=index&action=index
$imgURL  = $this->_dirImg;

$linkHome = URL::createLink("frontend", "index", "index");
$linkBook = URL::createLink("frontend", "book", "index");
$linkCategory = URL::createLink("frontend", "category", "index");
$linkRegister = URL::createLink("frontend", "user", "register");
$linkRegister = URL::createLink("frontend", "user", "register");
$linkRegister = URL::createLink("frontend", "user", "register");
?>

<header class="my-header sticky">
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="index.html">
                                <h2 class="mb-0" style="color: #5fcbc4">BookStore</h2>
                            </a>
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                    </li>
                                    <li><a href="index.html" class="my-menu-link active">Trang chủ</a></li>
                                    <li><a href="list.html">Sách</a></li>
                                    <li>
                                        <a href="category.html">Danh mục</a>
                                        <ul>
                                            <li><a href="list.html">Bà mẹ - Em bé</a></li>
                                            <li><a href="list.html">Chính Trị - Pháp Lý</a></li>
                                            <li><a href="list.html">Học Ngoại Ngữ</a></li>
                                            <li><a href="list.html">Công Nghệ Thông Tin</a></li>
                                            <li><a href="list.html">Giáo Khoa - Giáo Trình</a>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="top-header">
                            <ul class="header-dropdown">
                                <li class="onhover-dropdown mobile-account">
                                    <img src="<?= $imgURL ?>avatar.png" alt="avatar">
                                    <ul class="onhover-show-div">
                                        <li><a href="login.html">Đăng nhập</a></li>
                                        <li><a href="register.html">Đăng ký</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="icon-nav">
                                <ul>

                                    <?= HTML_Frontend::searchHeader($imgURL, 'openSearch()', "#"); ?>
                                    <?php require_once BLOCK_PATH . "cart.php"; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>