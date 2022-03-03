<?php
class GroupModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_GROUP);
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
		$query[] 	= "SELECT `id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`";
		$query[] 	= "FROM `{$this->table}` WHERE `id` > 0 ";

		// STATUS
		if (isset($params["status"]) && $params["status"] != "all") {
			$query[] = "AND `status`  =  '" . $params["status"] . "'";
		};

		// SEARCH
		if (isset($params["search"]) && !empty(trim($params["search"]))) {
			if (isset($params["search_by"]) && $params["search_by"] != "all" && !empty($params["search_by"])) {
				$query[] = "AND `" . $params["search_by"] . "` LIKE '%" . trim($params["search"]) . "%' ";
			} else {
				$query[] = "AND ( `name` LIKE '%" . trim($params["search"]) . "%' ";
				$query[] = "OR `id` LIKE '%" . trim($params["search"]) . "%' )";
			}
		}

		// GROUP ACP
		if (isset($params["group_acp"]) && $params["group_acp"] != "default") {
			$query[] = "AND `group_acp` = '" . $params["group_acp"] . "'";
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
			$position = ($params["pagination"]["currentPage"] - 1) * $pagination["pageRange"];
			$query[] = "LIMIT $position, " . $totalItemPerPage . "";
		};
		$query		= implode(' ', $query);
		$result = $this->listRecord($query);
		return $result;
	}

	public function countItemStatus($params, $options)
	{
		if ($options["task"] == "count-item-status") {

			$query[] = 'SELECT `status`, COUNT(*) AS `count`';
			$query[] = "FROM `$this->table` WHERE `id` > 0";

			// SEARCH
			if (isset($params["search"]) && !empty(trim($params["search"]))) {
				if (isset($params["search_by"]) && $params["search_by"] != "all" && !empty($params["search_by"])) {
					$query[] = "AND `" . $params["search_by"] . "` LIKE '%" . trim($params["search"]) . "%' ";
				} else {
					$query[] = "AND ( `name` LIKE '%" . trim($params["search"]) . "%' ";
					$query[] = "OR `id` LIKE '%" . trim($params["search"]) . "%' )";
				}
			}

			// GROUP ACP
			if (isset($params["group_acp"]) && $params["group_acp"] != "default") {
				$query[] = "AND `group_acp` = '" . $params["group_acp"] . "'";
			}

			$query[] = 'GROUP BY `status`';
			$query = implode(" ", $query);
			$result = $this->listRecord($query);
			$result = array_combine(array_column($result, "status"), array_column($result, "count"));
			$result = array("all" => array_sum($result)) + $result;
			return $result;
		}
	}

	public function changeGroupACP($params, $options = null)
	{
		$groupACP = $params['group_acp'] == 1 ? 0 : 1;
		$data = ['group_acp' => $groupACP];
		$where = [['id', $params['id']]];
		$this->update($data, $where);
	}

	public function changeStatus($params, $options = null)
	{

		if ($options["task"] == "change-ajax-status") {
			$id = $params["id"];
			$status = ($params["status"] == "active") ? "inactive" : "active";
			$time = time();
			$modifiedTime = date('H:i:s d/m/Y', $time);
			$arrayParams = array("status" => $status, "modified" => date('Y/m/d H:i:s', $time));

			$createSetUpdate = $this->createUpdateSQL($arrayParams);

			$link = URL::createLink($params["module"], $params["controller"], 'ajaxStatus', ['id' => $id, 'status' => $status]);

			$query = "UPDATE `$this->table` SET " . $createSetUpdate . " WHERE `id` = '" . $id . "'";
			$this->query($query);
			return array($id, $status, $link, "status", $modifiedTime);
		};
		if ($options["task"] == "change-group-acp") {
			$id = $params["id"];

			$groupACP = ($params["group_acp"] == "0") ? "1" : "0";
			$modifiedTime = date('H:i:s d/m/Y', time());
			$arrayParams = array("group_acp" => $groupACP, "modified" => date('Y/m/d H:i:s', strtotime($modifiedTime)));

			$createSetUpdate = $this->createUpdateSQL($arrayParams);

			$link = URL::createLink($params["module"], $params["controller"], 'ajaxGroupACP', ['id' => $id, 'group_acp' => $groupACP]);
			$query = "UPDATE `$this->table` SET " . $createSetUpdate . " WHERE `id` = '" . $id . "'";
			$this->query($query);
			return array($id, $groupACP, $link, "group_acp", $modifiedTime, $query);
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
			$ids = implode(', ', $params['cid']);
			$query = "UPDATE `{$this->table}` SET `status` = '{$options['task']}' WHERE `id` IN ({$ids})";
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
			$data["name"] = $params["form"]["name"];
			$data["group_acp"] = $params["form"]["group_acp"];
			$data["status"] = $params["form"]["status"];
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
			$data["name"] = $params["form"]["name"];
			$data["group_acp"] = $params["form"]["group_acp"];
			$data["status"] = $params["form"]["status"];
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
