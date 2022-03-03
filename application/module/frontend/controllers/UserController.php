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
			URL::checkRefreshPage($this->_arrParam['form']['token'], $this->_arrParam['module'], $this->_arrParam['controller'], 'register');
			// if (Session::get('token') == $this->_arrParam['form']['token']) {
			// 	Session::destroyKey('token');
			// 	URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'register');
			// 	// header("Refresh:0");
			// } else {
			// 	Session::set('token', $this->_arrParam['form']['token']);
			// }
			//important
			// echo '<pre>';
			// print_r($this->_arrParam);
			// echo '</pre>';

			$validate = $this->_validate;
			$validate->validate($this->_model);

			if (!$validate->isValid()) {
				$this->_view->error = (empty($validate->getError())) ? "" : $validate->showErrorsPublic();
			} else {
				$this->_arrParam["form"] = $validate->getSource();
				$id = $this->_model->saveItem($this->_arrParam, ["task" => "user-register"]);
				URL::redirect($this->_arrParam['module'], 'index', 'notice', ['type' => 'register-success']);
			}
		}

		$this->_view->render("user/register");
	}
}
