<?php
class UserController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('frontend/frontendlte/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function registerAction()
	{
		$data = $this->_arrParam["form"] ?? [];
		$title = (isset($this->_arrParam["id"])) ? "Edit" : "Add";
		if (isset($this->_arrParam['form']['submit'])) {
			//clear data in post request between request stage
			URL::checkRefreshPage($this->_arrParam['form']['token'], $this->_arrParam['module'], $this->_arrParam['controller'], 'register');

			$validate = $this->_validate;
			$validate->validate($this->_model);

			if (!$validate->isValid()) {
				$this->_view->error = (empty($validate->getError())) ? "" : $validate->showErrorsPublic();
			} else {
				$this->_arrParam["form"] = $validate->getSource();
				$id = $this->_model->saveItem($this->_arrParam, ["task" => "user-register"]);
				URL::redirect($this->_arrParam['module'], 'user', 'register', ['type' => 'register-success']);
			}
		}

		$this->_view->render("user/register");
	}
}
