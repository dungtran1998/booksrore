<?php

class URL
{
    public static function createLink($module, $controller, $action, $params = null)
    {
        $linkParams = '';
        if ($params) {
            foreach ($params as $key => $value) {
                $linkParams .= "&{$key}={$value}";
            }
        }
        $url = sprintf('index.php?module=%s&controller=%s&action=%s%s', $module, $controller, $action, $linkParams);
        return $url;
    }

    public static function redirect($module, $controller, $action, $params = null)
    {
        $linkParams = '';
        if ($params) {
            foreach ($params as $key => $value) {
                $linkParams .= "&{$key}={$value}";
            }
        }
        $url = sprintf('index.php?module=%s&controller=%s&action=%s%s', $module, $controller, $action, $linkParams);
        header("location: {$url}");
        exit();
    }

    public static function checkRefreshPage($value, $module, $controller, $action)
    {
        if (Session::get('token') == $value) {
            Session::destroyKey('token');
            URL::redirect($module, $controller, $action);
            // header("Refresh:0");
        } else {
            Session::set('token', $value);
        }
    }
}
