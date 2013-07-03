<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Add JS and CSS loader in codeigniter loader
 *
 * @link http://github.com/zeroion/jscss
 * @copyright Copyright (c) 2013, Jihun LEE <http://jihoonlee.com>
 */

class GAMESTUDIO_Loader extends CI_Loader
{

	/**
	 * List of loaded JS files
	 */
	protected $_loaded_js_files= array();


	/**
	 * List of loaded CSS files
	 */
	protected $_loaded_css_files= array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Add CSS File
	 */
	public function cssFile($filepath, $media = 'all')
	{
		if (is_array($filepath))
		{
			foreach ($filepath as $val)
			{
				$this->cssFile($val, $media);
			}
			return;
		}

		if (!$filepath)
		{
			return;
		}

		if(array_key_exists($filepath, $this->_loaded_css_files)) return;

		if(substr($filepath, 0, 7) == 'http://')
		{

		}
		else
		{
			$filepath = str_replace('./', '/', $filepath);
			$filepath = dirname($_SERVER['SCRIPT_NAME']) . $filepath;
		}

		$this->_loaded_css_files[$filepath] = array(
			'media' => $media
		);
	}

	public function jsFile($filepath)
	{

		if (is_array($filepath))
		{
			foreach ($filepath as $val)
			{
				$this->jsFile($val);
			}
			return;
		}

		if (!$filepath)
		{
			return;
		}

		if(array_key_exists($filepath, $this->_loaded_js_files)) return;

		$filepath = str_replace('./', '/', $filepath);
		$filepath = dirname($_SERVER['SCRIPT_NAME']) . $filepath;

		$this->_loaded_js_files[$filepath] = array();
	}
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */