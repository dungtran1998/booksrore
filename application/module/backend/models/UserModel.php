<?php
class UserModel extends Model
{
	private $_column = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id');

	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_USER);
	}

	public function countItem($params = null)
	{
		$query[] = "SELECT COUNT(`id`) as  `total`";
		$query[] = "FROM `$this->table` WHERE `id` > 0";

		if (isset($params["status"]) && $params["status"] != "all") {
			$query[] = "AND `status` = '" . $params["status"] . "'";
		}
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result["total"];
	}

	public function listItems($params, $options = null)
	{
		$query[] 	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`password`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `u`.`register_date`, `u`.`register_ip`, `u`.`status`, `u`.`ordering`, `u`.`group_id`,`g`.`name` AS `group_name` ";
		$query[] 	= "FROM `{$this->table}` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id` ";
		$query[]    = "WHERE `u`.`id` >0 ";

		// STATUS
		if (isset($params["status"]) && $params["status"] != "all") {
			$query[] = "AND `u`.`status`  =  '" . $params["status"] . "' ";
		};

		// SEARCH
		if (isset($params["search"]) && !empty(trim($params["search"]))) {
			if (isset($params["search_by"]) && $params["search_by"] != "all" && !empty($params["search_by"])) {
				$query[] = "AND `u`.`" . $params["search_by"] . "` LIKE '%" . trim($params["search"]) . "%' ";
			} else {
				$query[] = "AND (`u`.`username` LIKE '%" . trim($params["search"]) . "%' ";
				$query[] = "OR `u`.`id` LIKE '%" . trim($params["search"]) . "%' ) ";
			}
		}

		// SORT
		if (!empty($params["filter_column"]) && !empty($params["filter_column_dir"])) {
			$column  = $params["filter_column"];
			$dir  = strtoupper($params["filter_column_dir"]);

			$query[] = "ORDER BY `$column` $dir ";
		}

		// PAGINATON
		$pagination = $params["pagination"];
		$totalItemPerPage = $pagination["totalItemsPerPage"];
		if ($pagination["currentPage"]) {
			$position = ($params["pagination"]["currentPage"] - 1) * $totalItemPerPage;
			$query[] = " LIMIT $position, " . $totalItemPerPage . " ";
		};
		$query		= implode('', $query);
		$result = $this->listRecord($query);
		return $result;
	}

	public function listGroupName()
	{
		$query = "SELECT `id`,`name` FROM `group`";
		$result = $this->fetchPair($query);
		$arrResult  = ['0' => "- Select Group"];
		foreach ($result as $key => $value) {
			$arrResult[$key] = $value;
		}
		return $arrResult;
	}

	public function countItemStatus($params, $options)
	{
		if ($options["task"] == "count-item-status") {

			$query[] = 'SELECT `u`.`status`, COUNT(*) AS `count`';
			$query[] = "FROM `$this->table` AS `u` WHERE `u`.`id` > 0";

			// SEARCH
			if (isset($params["search"]) && !empty(trim($params["search"]))) {
				if (isset($params["search_by"]) && $params["search_by"] != "all" && !empty($params["search_by"])) {
					$query[] = "AND `u`.`" . $params["search_by"] . "` LIKE '%" . trim($params["search"]) . "%' ";
				} else {
					$query[] = "AND ( `u`.`username` LIKE '%" . trim($params["search"]) . "%' ";
					$query[] = "OR `u`.`id` LIKE '%" . trim($params["search"]) . "%' )";
				}
			}

			$query[] = 'GROUP BY `status`';
			$query = implode(" ", $query);
			$result = $this->listRecord($query);
			$arrayStatus = array_column($result, "status");
			foreach (array_column($result, "status") as $key => $value) {
				if ($value == 'active') $arrayStatus[$key] = 'active';
				if ($value == 'inactive') $arrayStatus[$key] = 'inactive';
			}
			$result = array_combine($arrayStatus, array_column($result, "count"));
			$result = array("all" => array_sum($result)) + $result;
			return $result;
		}
	}

	public function changeStatus($params, $options = null)
	{

		if ($options["task"] == "change-ajax-status") {
			$id = $params["id"];
			$status = ($params["status"] == "active") ? "inactive" : "active";
			$time = time();
			$modifiedTime = date('d/m/Y', $time);
			$arrayParams = array("status" => $status, "modified" => date('Y/m/d H:i:s', $time));

			$createSetUpdate = $this->createUpdateSQL($arrayParams);

			$link = URL::createLink($params["module"], $params["controller"], 'ajaxStatus', ['id' => $id, 'status' => $status]);

			$query = "UPDATE `$this->table` SET " . $createSetUpdate . " WHERE `id` = '" . $id . "'";
			$this->query($query);
			return array($id, $status, $link, "status", $modifiedTime);
		};
	}

	public function multiStatus($params, $options = null)
	{
		if ($options['task'] == 'active' || $options['task'] == 'inactive') {
			if ($options['task'] == "active") {
				Session::set("notify", HelperBackend::createNotify("success", "bulk-action-active-success"));
			}
			if ($options['task'] == "inactive") {
				Session::set("notify", HelperBackend::createNotify("success", "bulk-action-inactive-success"));
			}
			$ids = implode(',', $params['cid']);

			$query = "UPDATE `{$this->table}` SET `status` = '{$options['task']}' WHERE `id` IN ({$ids})";
			if ($options['number'] == true) {
				$status = ($options['task'] == 'active') ? '1' : '0';
				$query = "UPDATE `{$this->table}` SET `status` = '$status' WHERE `id` IN ({$ids})";
			};
			$this->query($query);
		}
	}

	public function deleteItem($params, $options = null)
	{
		Session::set("notify", HelperBackend::createNotify("success", "bulk-action-delete-success"));
		$ids = isset($params['id']) ? [$params['id']] : $params['cid'];
		$this->delete($ids);
	}
	// Save Item
	public function saveItem($params, $options = null)
	{
		if ($options["task"] == "add") {
			$data["username"] = $params["form"]["username"];
			$data["email"] = $params["form"]["email"];
			$data["fullname"] = $params["form"]["fullname"];
			$data["password"] = md5($params["form"]["password"]);
			$data["status"] = $params["form"]["status"];
			$data["ordering"] = $params["form"]["ordering"];
			$data["group_id"] = $params["form"]["group_id"];

			$data["created"] = date('Y/m/d H:i:s', time());;
			$data["modified"] = date('Y/m/d H:i:s', time());
			$data["created_by"] = "admin";
			$data["modified_by"] = "admin";
			$result = $this->insert($data);
			if ($result) {
				Session::set("notify", HelperBackend::createNotify("success", "insert-success"));
			} else {
				Session::set("notify", HelperBackend::createNotify("warning", "insert-failed"));
			}
			return $result;
		}
		if ($options["task"] == "edit") {
			$data["username"] = $params["form"]["username"];
			$data["email"] = $params["form"]["email"];
			$data["fullname"] = $params["form"]["fullname"];
			$data["password"] = md5($params["form"]["password"]);
			$data["status"] = $params["form"]["status"];
			$data["ordering"] = $params["form"]["ordering"];
			$data["group_id"] = $params["form"]["group_id"];

			$data["modified"] = date('Y/m/d H:i:s', time());
			$data["modified_by"] = "admin";
			$data["id"] = $params["id"];
			$result = $this->update($data, array(["id", $data["id"]]));
			if ($result) {
				Session::set("notify", HelperBackend::createNotify("success", "update-success"));
			} else {
				Session::set("notify", HelperBackend::createNotify("warning", "update-failed"));
			}
			return $result;
		}
	}

	// Info item\
	public function infoItem($id, $options = null)
	{
		$query[] =  "SELECT * FROM `$this->table` WHERE `id` = $id";
		$query = implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}
}
