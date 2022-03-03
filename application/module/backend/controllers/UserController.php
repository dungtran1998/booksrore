<?php
class UserController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/adminlte/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->_title = 'User Controller :: List';
		$totalItem = $this->_model->countItem($this->_arrParam);
		$this->_view->pagination = new Pagination($totalItem, $this->_pagination);
		$this->_view->itemStatusCount = $this->_model->countItemStatus($this->_arrParam, ["task" => "count-item-status"]);
		$this->_view->groupList = $this->_model->listGroupName();

		$this->_view->items = $this->_model->listItems($this->_arrParam);

		$this->_view->render('user/index');
	}

	public function formAction()
	{
		$data = $this->_arrParam["form"] ?? [];
		$title = (isset($this->_arrParam["id"])) ? "Edit" : "Add";
		$this->_view->_title = 'User Controller :: ' . $title;
		$this->_view->groupList = $this->_model->listGroupName();
		if (isset($this->_arrParam["id"])) {
			$this->_arrParam["form"] = $this->_model->infoItem($this->_arrParam["id"]);
			$this->_view->arrParams["form"] = $this->_arrParam["form"];
			if (empty($this->_arrParam["form"])) {
				URL::redirect($this->_arrParam["module"], $this->_arrParam["controller"], "form");
			}
		}

		if (isset($data["token"])) {
			$validate = $this->_validate;
			if (isset($this->_arrParam["id"])) {
				$validate->addSourceElement("id", $this->_arrParam["id"]);
			}
			$validate->validate($this->_model);

			if (!$validate->isValid()) {
				$this->_view->error = (empty($validate->getError())) ? "" : $validate->showErrorsAdmin();
			} else {
				$this->_arrParam["form"] = $validate->getSource();
				$task = (isset($this->_arrParam["id"])) ? "edit" : "add";
				$id = $this->_model->saveItem($this->_arrParam, ["task" => $task]);
				if ($task == "edit") $id = $this->_arrParam['id'];
				$data = $this->_arrParam["form"];
				if ($data["type"] == "save") {
					URL::redirect($this->_arrParam["module"], $this->_arrParam["controller"], $this->_arrParam["action"], ["id" => $id]);
				}
				if ($data["type"] == "save-new") {
					URL::redirect($this->_arrParam["module"], $this->_arrParam["controller"], $this->_arrParam["action"]);
				}
				if ($data["type"] == "save-close") {
					URL::redirect($this->_arrParam["module"], $this->_arrParam["controller"], "index");
				}
			}
		}
		$this->_view->render('user/add');
	}

	public function changeGroupNameAction()
	{
		$data = array('group_id' => $this->_arrParam['group_id']);
		$where = array(["id", $this->_arrParam['id'], null]);
		$result = $this->_model->update($data, $where);
		if ($result) {
			echo json_encode(array('status' => true));
		} else {
			echo json_encode(array('status' => false));
		}
	}


	public function changeStatusAction()
	{
		$this->_model->changeStatus($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function deleteAction()
	{
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function multiActiveAction()
	{
		$this->_model->multiStatus($this->_arrParam, ['task' => 'active', 'number' => true]);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function multiInactiveAction()
	{
		$this->_model->multiStatus($this->_arrParam, ['task' => 'inactive']);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function multiDeleteAction()
	{
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}


	public function ajaxStatusAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ["task" => "change-ajax-status"]);
		echo json_encode($result);
	}
}
