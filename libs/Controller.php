<?php

class Controller
{

	// View Object
	protected $_view;

	// Model Object
	protected $_model;

	// Template object
	protected $_templateObj;

	// Params (GET - POST)
	protected $_arrParam;

	// Pagination
	protected $_pagination = array(
		"totalItemsPerPage" => 5,
		"pageRange"      => 3
	);

	public function __construct($arrParams)
	{
		$this->setModel($arrParams['module'], $arrParams['controller']);
		$this->setTemplate($this);
		$this->setView($arrParams['module']);
		$this->_pagination["currentPage"] = isset($arrParams["page"]) ? $arrParams["page"] : 1;
		$arrParams["pagination"] = $this->_pagination;
		$this->setParams($arrParams);
		$this->setValidate($arrParams['module'], $arrParams['controller'], $arrParams);
		$this->_view->arrParams = $arrParams;
	}

	// SET PAGINATION 
	public function setPaginationConfig($config)
	{
		$this->_pagination["totalItemsPerPage"] = $config["totalItemsPerPage"];
		$this->_pagination["pageRange"] =  $config["pageRange"];
		$arrParams["pagination"] = $this->_pagination;
		$this->_view->arrParams = $arrParams;
	}
	// SET MODEL
	public function setModel($moduleName, $modelName)
	{
		$modelName = ucfirst($modelName) . 'Model';
		$path = MODULE_PATH . $moduleName . DS . 'models' .  DS . $modelName . '.php';
		if (file_exists($path)) {
			require_once $path;
			$this->_model	= new $modelName();
		}
	}

	// SET VALIDATE
	public  function setValidate($moduleName, $controllerName, $arrParam)
	{
		$controllerName = ucfirst($controllerName) . 'Validate';
		$path =  MODULE_PATH . $moduleName . DS . 'validate' .  DS . $controllerName . '.php';
		if (file_exists($path)) {
			require_once $path;
			$this->_validate = new $controllerName($arrParam);
		}
	}

	// GET MODEL
	public function getModel()
	{
		return $this->_model;
	}

	// SET VIEW
	public function setView($moduleName)
	{
		$this->_view = new View($moduleName);
	}

	// GET VIEW
	public function getView()
	{
		return $this->_view;
	}

	// SET TEMPLATE
	public function setTemplate()
	{
		$this->_templateObj = new Template($this);
	}

	// GET TEMPLATE
	public function getTemplate()
	{
		return $this->_templateObj;
	}

	// GET PARAMS
	public function setParams($arrParam)
	{
		$this->_arrParam = $arrParam;
	}

	// GET PARAMS
	public function getParams($arrParam)
	{
		$this->_arrParam = $arrParam;
	}
}
