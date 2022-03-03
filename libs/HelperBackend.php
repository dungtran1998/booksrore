<?php

class HelperBackend
{
    public static function button($type, $name, $class = 'btn-info', $options = ['small' => false, 'circle' => false])
    {
        $optionsClass = '';
        if ($options['small']) $optionsClass .= ' btn-sm';
        if ($options['circle']) $optionsClass .= ' rounded-circle';
        return sprintf('<button type="%s" class="btn %s %s">%s</button>', $type, $class, $optionsClass, $name);
    }

    public static function buttonLink($link, $name, $class = 'btn-info', $options = ['small' => false, 'circle' => false])
    {
        $optionsClass = '';
        if ($options['small']) $optionsClass .= ' btn-sm';
        if ($options['circle']) $optionsClass .= ' rounded-circle';
        return sprintf('<a href="%s" class="btn %s %s">%s</a>', $link, $class, $optionsClass, $name);
    }

    public static function itemGroupACP($module, $controller, $id, $value)
    {
        // $link = URL::createLink($module, $controller, 'changeGroupACP', ['id' => $id, 'group_acp' => $value]);
        $link = URL::createLink($module, $controller, 'ajaxGroupACP', ['id' => $id, 'group_acp' => $value]);
        $colorClass = 'btn-success';
        $icon = 'fa-check';

        if ($value == 0) {
            $colorClass = 'btn-danger';
            $icon = 'fa-minus';
        }

        // return sprintf('<a href="%s" class="btn %s rounded-circle btn-sm"><i class="fas %s"></i></a>', $link, $colorClass, $icon);
        return sprintf('<a id="group_acp-' . $id . '" href="javascript:changeStatus(\'%s\')" class="btn %s rounded-circle btn-sm"><i class="fas %s"></i></a>', $link, $colorClass, $icon);
    }

    public static function itemStatus($module, $controller, $id, $value)
    {
        // $link = URL::createLink($module, $controller, 'changeStatus', ['id' => $id, 'status' => $value]);
        $link = URL::createLink($module, $controller, 'ajaxStatus', ['id' => $id, 'status' => $value]);
        $colorClass = 'btn-success';
        $icon = 'fa-check';

        if ($value == 'inactive'  || $value == '0') {
            $colorClass = 'btn-danger';
            $icon = 'fa-minus';
        }

        // return sprintf('<a href="%s" class="btn %s rounded-circle btn-sm"><i class="fas %s"></i></a>', $link, $colorClass, $icon);
        return sprintf('<a id="status-' . $id . '" href="javascript:changeStatus(\'%s\')" class="btn %s rounded-circle btn-sm"><i class="fas %s"></i></a>', $link, $colorClass, $icon);
    }

    public static function itemHistory($by, $time, $options = true)
    {
        if ($time) $time = date('H:i:s d/m/Y', strtotime($time));
        if (!$options) $time = date('d/m/Y', strtotime($time));
        $xhtml = sprintf('
        <p class="mb-0"><i class="far fa-user"></i> %s</p>
        <p class="mb-0"><i class="far fa-clock"></i> %s</p>
        ', $by, $time);
        return $xhtml;
    }
    public static function highlight($search, $value)
    {
        if (!empty(trim($search))) {
            return preg_replace('/' . preg_quote($search, '/') . '/ui', '<mark>$0</mark>', $value);
        }

        return $value;
    }

    public static function showFilterStatus($module, $controller, $itemsStatusAmount, $status, $search, $number = false)
    {
        $xhtml = "";

        foreach ($itemsStatusAmount as $key => $value) {
            $keyFlag = $key;
            if ($number) {
                if ($key == 'active') $keyFlag = 'active';
                if ($key == 'inactive') $keyFlag = 'inactive';
            }
            $link = (empty($search)) ? URL::createLink($module, $controller, "index", ['status' => $keyFlag]) : URL::createLink($module, $controller, "index", ['status' => $key, 'search' => $search]);

            $btn = ($status == $keyFlag) ? "btn-info" : "btn-secondary";
            $xhtml .= ' <a href="' . $link . '" class="btn ' . $btn . '">' . ucfirst($key)  . ' <span class="badge badge-pill badge-light">' . $value . '</span></a>';
        }
        return $xhtml;
    }


    public static function cmsLinkSort($name, $column, $columnPost, $orderPost)
    {

        // <i class="fa fa-angle-double-down"></i>
        // <i class="fa fa-angle-double-up"></i>
        $icon = "";
        $order = ($orderPost == "asc") ? "desc" : "asc";
        if ($column == $columnPost) {
            $direction = $order == "desc" ? "up" : "down";
            $icon = '<i class="fa fa-angle-double-' . $direction . '"></i>';
        }
        $xhtml = '<a href="javascript:sortList(this,\'' . $column . '\',\'' . $order . '\')">
        ' . $name . $icon . '</a>';
        return $xhtml;
    }

    // Create Selectbox
    public static function cmsSelectBox($name, $class, $arrValue, $keySelect = "", $id = '')
    {
        $xhtml = '<select ' . $id . ' name = ' . $name . ' class="' . $class . '">';
        foreach ($arrValue as $key => $value) {
            if (strval($key) == $keySelect) {
                $xhtml .= '<option selected value="' . $key . '">' . $value . '</option>';
            } else {
                $xhtml .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $xhtml .= '</select>';
        return $xhtml;
    }

    // Create input
    public static function cmsInput($type, $name, $class, $value = null, $readonly = false, $options = '')
    {
        $readonly = ($readonly) ? "readonly" : "";
        $xhtml = '<input class="' . $class . '" type="' . $type . '" name="' . $name . '" value="' . $value . '" ' . $readonly . $options . '>';
        return $xhtml;
    }

    // Create row input
    public static function cmsRowInput($name, $input, $required = true)
    {
        $requiredTxt = ($required == true) ? ' <span class="text-danger">*</span>' : "";
        $xhtml = '<div class="form-group">';
        $xhtml .= '<label class = "">' . ucfirst($name) . $requiredTxt . '</label>' . $input . '</div>';
        return $xhtml;
    }

    // Create Notify
    public static function createNotify($type, $message)
    {
        return array("type" => $type, "message" => $message);
    }

    // Create Show Toast
    public static function showMessage()
    {
        $message = Session::get("notify");
        Session::destroyKey("notify");
        return "showToast('" . $message["type"] . "','" . $message["message"] . "')";
    }

    // Get Parameter URL
    public static function createLinkParameter()
    {
        $link = "";
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url_components = parse_url($url);
        $dirName = explode("/", $url_components["path"]);
        $link .= $dirName[count($dirName) - 1] . "?";
        parse_str($url_components['query'] ?? "", $params);
        foreach ($params as $key => $value) {
            if ($key != "page") {
                $link .= $key . "=" . $value . "&";
            }
        };
        return $link;
    }

    // Create Button Link
    public static function cmsButtonLink($name, $class, $htmlType, $link = "#", $dataType = null, $type = "submit")
    {
        $xhtml = "";
        if ($htmlType == "button") {
            $xhtml .= '<button data-type="' . $dataType . '" type="' . $type . '" class="btn ' . $class . '">' . $name . '</button> ';
        } else {
            $xhtml .= '<a href="' . $link . '" class="btn ' . $class . '">' . $name . '</a> ';
        }
        return $xhtml;
    }

    // Create sidebar menu
    public static function cmsSideBarMenu($arrMenu, $module, $controller, $action)
    {
        $xhtml = '<ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">';
        foreach ($arrMenu as $key => $value) {
            $child = "";
            if (isset($value["child"])) {
                $child = '<ul class="nav nav-treeview">';
                foreach ($value["child"] as $key1 => $value2) {
                    $active2 = ($controller == $value["name"] && $value2["action"] == $action) ? "active" : "";
                    $child .= ' <li class="nav-item">
                                    <a href="' . $value2["link"] . '" class="nav-link ' . $active2 . '">
                                        ' . $value2["icon"] . '
                                        <p>' . ucfirst($value2["name"])  . '</p>
                                    </a>
                                </li>';
                }
                $child .= '</ul>';
            }

            $active = ($controller == $value["name"]) ? "active" : "";
            $iconRight = (isset($value["child"])) ? '<i class="fas fa-angle-left right"></i>' : '';
            $xhtml .= '
                <li class="nav-item">
                    <a href="' . $value["link"] . '" class="nav-link ' . $active . '">
                        ' . $value["icon"] . '
                        <p>' . ucfirst($value["name"]) . $iconRight . '
                        </p>
                    </a>

                ' . $child . '
                </li>';
        }
        $xhtml .= '</ul>';
        return $xhtml;
    }
}
