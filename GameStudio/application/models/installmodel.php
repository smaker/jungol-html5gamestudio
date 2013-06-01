<?php
class Installmodel extends CI_Model
{
	private $generalConfigFile;
	private $dbConfigFile;

	public function __construct()
	{
		parent::__construct();

		$this->generalConfigFile = APPPATH . 'files/config/general.config.php';
		$this->dbConfigFile = APPPATH . 'files/config/db.config.php';
	}

	public function is_installed()
	{
		if(/*file_exists($this->generalConfigFile) && */file_exists($this->dbConfigFile))
		{
			return TRUE;
		}
		return FALSE;
	}

	public function load_general_config()
	{
		include $this->generalConfigFile;
	}

	public function load_db_config()
	{
		include $this->dbConfigFile;
	}

	public function get_general_config_file()
	{
		return $this->generalConfigFile;
	}

	public function get_db_config_file()
	{
		return $this->dbConfigFile;
	}

	public function set_general_config_file($file)
	{
		$this->generalConfigFile = $file;
	}

	public function set_db_config_file($file)
	{
	}
}