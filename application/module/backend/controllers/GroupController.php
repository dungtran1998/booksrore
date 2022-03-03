<?php
class GroupController extends Controller
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
		$this->_view->_title = 'Group Controller :: List';
		$totalItem = $this->_model->countItem($this->_arrParam);
		$this->_view->pagination = new Pagination($totalItem, $this->_pagination);
		$this->_view->itemStatusCount = $this->_model->countItemStatus($this->_arrParam, ["task" => "count-item-status"]);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->render('group/index');
	}

	public function formAction()
	{
		$data = $this->_arrParam["form"] ?? [];
		$title = (isset($this->_arrParam["id"])) ? "Edit" : "Add";
		$this->_view->_title = 'Group Controller :: ' . $title;
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
		$this->_view->render('group/add');
	}

	public function changeGroupACPAction()
	{
		$this->_model->changeGroupACP($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
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
		$this->_model->multiStatus($this->_arrParam, ['task' => 'active']);
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

	public function addAction()
	{
		$this->_view->_title = 'Group Controller :: Add';
		$this->_view->render('group/add');
	}

	public function ajaxStatusAction()
	{
		// header("Access-Control-Allow-Origin");
		// header('Content-type: application/json');
		$result = $this->_model->changeStatus($this->_arrParam, ["task" => "change-ajax-status"]);
		// header('Content-type: application/json');
		echo json_encode($result);
	}
	public function ajaxGroupACPAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ["task" => "change-group-acp"]);
		echo json_encode($result);
	}
}
