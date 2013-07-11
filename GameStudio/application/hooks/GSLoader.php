<?php
/**
 * @class GSLoader
 * @var 0.1
 */
class GSLoader
{
	protected $CI; // << Codeigniter 인스턴스 객체

	/**
	 * Constructor
	 * @access public
	 */
	public function GSLoader()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('installmodel');

		$module = strtolower($this->CI->uri->segment(1));

		if($module != 'install' && !$this->CI->installmodel->is_installed())
		{
			$this->CI->load->helper('url');

			redirect('/install/', 302);
		}

		 // 세션 시작
		session_start();

		require_once(BASEPATH.'database/DB.php');

		$this->CI->load->model('member_model');

		$data = array(
			'is_logged' => FALSE,
			'logged_info' => array()
		);

		/**
		 * @TODO 로그인 여부 확인
		 */
		if(isset($_SESSION['is_logged']) && isset($_SESSION['member_no']) && $_SESSION['is_logged'])
		{
			if($_SESSION['is_logged'] && $_SESSION['ipaddress'] == $_SERVER['REMOTE_ADDR'])
			{
				$logged_info = $this->CI->member_model->getMemberInfo($_SESSION['member_no']);
				$data = array(
					'is_logged' => TRUE,
					'logged_info' => $logged_info
				);
			}
			else
			{
				$_SESSION['is_logged'] = FALSE;

				$data = array(
					'is_logged' => FALSE,
					'logged_info' => array()
				);
			}
		}

		$this->CI->load->vars($data);
	}

	public function DBConnection()
	{
		if(is_readable(APPPATH . 'files/config/db.config.php'))
		{
			include (APPPATH . 'files/config/db.config.php');

			// DB에 접속합니다.
			$this->CI->load->database($db_info);
		}
	}
}

/* End of file : GSLoader.php */
/* Location : ./application/hooks/GSLoader.php */