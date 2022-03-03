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
        $this->addRule("username", "existRecord", ['database' => $model, "query" => $queryUserName], false)
            ->addRule("fullname", "string", ["min" => 3, "max" => 40], false)
            ->addRule("email", "email", [], false)
            ->addRule("password", "password", ['action' => "add"], false);
        $this->run();
    }
}
