<?php
$module = $this->arrParams["module"];
$controller = $this->arrParams["controller"];
$action = $this->arrParams["action"];
$arrMenu  = [
    "dashboard" => [
        "name" => "dashboard",
        "icon" => '<i class="nav-icon fas fa-tachometer-alt"></i>',
        "link" => "#"
    ],
    "group" => [
        "name" => "group",
        "icon" => '<i class="nav-icon fas fa-users"></i>',
        "link" => "#",
        "child" => [
            "list" => [
                "icon" => '<i class="nav-icon fas fa-list-ul"></i>',
                "name" => "list",
                "action" => "index",
                "link" => URL::createLink("backend", "group", "index")
            ],
            "form" => [
                "icon" => '<i class="nav-icon fas fa-edit"></i>',
                "name" => "form",
                "action" => "form",
                "link" => URL::createLink("backend", "group", "form")
            ]
        ]
    ],
    "user" => [
        "name" => "user",
        "icon" => '<i class="nav-icon fas fa-user"></i>',
        "link" => "#",
        "child" => [
            "list" => [
                "icon" => '<i class="nav-icon fas fa-list-ul"></i>',
                "name" => "list",
                "action" => "index",
                "link" => URL::createLink("backend", "user", "index")
            ],
            "form" => [
                "icon" => '<i class="nav-icon fas fa-edit"></i>',
                "name" => "form",
                "action" => "form",
                "link" => URL::createLink("backend", "user", "form")
            ]
        ]
    ],
    "category" => [
        "name" => "category",
        "icon" => '<i class="nav-icon fas fa-thumbtack"></i>',
        "link" => "#",
        "child" => [
            "list" => [
                "icon" => '<i class="nav-icon fas fa-list-ul"></i>',
                "name" => "list",
                "action" => "index",
                "link" => URL::createLink("backend", "category", "index")
            ],
            "form" => [
                "icon" => '<i class="nav-icon fas fa-edit"></i>',
                "name" => "form",
                "action" => "form",
                "link" => URL::createLink("backend", "category", "form")
            ]
        ]
    ],
    "book" => [
        "name" => "book",
        "icon" => '<i class="nav-icon fas fa-book-open"></i>',
        "link" => "#",
        "child" => [
            "list" => [
                "icon" => '<i class="nav-icon fas fa-list-ul"></i>',
                "name" => "list",
                "action" => "index",
                "link" => URL::createLink("backend", "book", "index")
            ],
            "form" => [
                "icon" => '<i class="nav-icon fas fa-edit"></i>',
                "name" => "form",
                "action" => "form",
                "link" => URL::createLink("backend", "book", "form")
            ]
        ]
    ]
];

$menuSideBar = HelperBackend::cmsSideBarMenu($arrMenu, $module, $controller, $action);


?>

<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="<?= $this->_dirImg ?>logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
        <span class="brand-text font-weight-light">Admin Control Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $this->_dirImg ?>avatar.jpg" class="img-circle elevation-2" alt="User Image" />
            </div>
            <div class="info">
                <a href="#" class="d-block">ZendVN</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <!-- <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Group
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=group&action=index" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="group-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="user-list.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="user-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-thumbtack"></i>
                        <p>
                            Category
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="category-list.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="category-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Book
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="book-list.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="book-form.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> -->
            <?php echo $menuSideBar; ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>