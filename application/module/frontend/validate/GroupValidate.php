<?php
class GroupValidate extends Validate
{
    public function __construct($source)
    {
        parent::__construct($source["form"] ?? []);
    }

    public function validate($model)
    {
        if (isset($this->getSource()["id"])) {
            $query = "SELECT `name` FROM `" . $model->getTable() . "` WHERE `name` = '" . $this->getSource()["name"] . "' AND `id` <> '" . $this->getSource()["id"] . "'";
        } else {
            $query = "SELECT `name` FROM `" . $model->getTable() . "` WHERE `name` = '" . $this->getSource()["name"] . "' ";
        }

        $this->addRule("name", "string", ["min" => 3, "max" => 20], false)
            ->addRule("name", "existRecord", ['database' => $model, "query" => $query], false)
            ->addRule("group_acp", "selectBox", ["invalid" => "default"], false)
            ->addRule("status", "selectBox", ["invalid" => "default"], false);
        $this->run();
    }
}
