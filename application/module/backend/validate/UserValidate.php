<?php
class UserValidate extends Validate
{
    public function __construct($source)
    {
        parent::__construct($source["form"] ?? []);
    }

    public function validate($model)
    {
        $queryUserName = "SELECT `username` FROM `" . $model->getTable() . "` WHERE `username` = '" . $this->getSource()["username"] . "'";
        if (isset($this->getSource()["id"])) {
            $queryUserName .= " AND `id` <> '" . $this->getSource()["id"] . "'";
        }


        $queryEmail = "SELECT `email` FROM `" . $model->getTable() . "` WHERE `email` = '" . $this->getSource()["email"] . "'";
        $this->addRule("username", "existRecord", ['database' => $model, "query" => $queryUserName], false)
            ->addRule("fullname", "string", ["min" => 3, "max" => 40], false)
            ->addRule("email", "email", ['database' => $model, "query" => $queryEmail], false)
            ->addRule("ordering", "int", ["min" => "1", "max" => '20'], false)
            ->addRule("group_id", "selectBox", ["invalid" => "default"], false)
            ->addRule("status", "selectBox", ["invalid" => "default"], false);
        $this->run();
    }
}
