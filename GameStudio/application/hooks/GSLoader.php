<?php
/**
 * @class GSLoader
 */
class GSLoader
{
	private $CI; // << Codeigniter 인스턴스 객체

	function GSLoader() {
		$this->CI = &get_instance();

		$this->CI->load->model('installmodel');

		$module = strtolower($this->CI->uri->segment(1));

		if($module != 'install' && !$this->CI->installmodel->is_installed())
		{
			$this->CI->load->helper('url');

			redirect('/install/', 302);
		}
	}

	/**
	 * @brief 세션 시작
	 */
	function Session() {
		session_start();
	}
}

/* End of file : GSLoader.php */
/* Location : ./application/hooks/GSLoader.php */