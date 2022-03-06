<?php
class UserModel extends Model
{
	private $_column = array('id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'register_date', 'register_ip', 'status', 'ordering', 'group_id');

	public function __construct()
	{
		parent::__construct();
		$this->setTable(TBL_USER);
	}
	// Save Item
	public function saveItem($params, $options = null)
	{
		if ($options["task"] == "user-register") {
			$data["username"] = $params["form"]["username"];
			$data["email"] = $params["form"]["email"];
			$data["fullname"] = $params["form"]["fullname"];
			$data["password"] = md5($params["form"]["password"]);
			$data["status"] = "inactive";
			$data["group_id"] = "3";

			$data["created"] = date('Y/m/d H:i:s', time());;
			$data["modified"] = date('Y/m/d H:i:s', time());
			$data["created_by"] = $params["form"]["username"];
			$data["modified_by"] = $params["form"]["username"];
			$data["register_ip"] = $_SERVER['REMOTE_ADDR'];
			$data["register_date"] = date('Y/m/d H:i:s', time());

			$result = $this->insert($data);
			if ($result) {
				Session::set("success-register", HelperBackend::createStatusLogin("Sign up success", "Back to sign in"));
			} else {
				Session::set("success-register", HelperBackend::createStatusLogin("Sign up failed", "Back to sign up again"));
			}
			return $result;
		}
	}
}
