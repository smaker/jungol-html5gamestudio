<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	/**
	 * 설치 화면
	 */
	public function index()
	{
		// URL Helper를 불러옵니다
		$this->load->helper('url');

		// Install Model을 불러옵니다
		$this->load->model('Installmodel');

		// GameStudio가 설치되어 있으면 오류를 출력합니다
		if($this->Installmodel->is_installed())
		{
			// View 파일을 지정
			$this->load->view('message/gamestudio_already_installed');
		}
		else
		{
			// 약관 파일을 읽어옵니다
			$agreement = nl2br(file_get_contents(APPPATH . '../README.ko'));

			// View 파일에서 사용할 변수 정의
			$data = array(
				'base_url' => $this->config->item('base_url'),
				'agreement' => $agreement
			);

			// 설치되어 있지 않으면 설치 화면을 보여줍니다
			$this->load->view('install/install_page', $data);
		}
	}

	/**
	 *
	 */
	public function step()
	{

		$this->load->model('Installmodel');

		$this->load->helper('url');

		// URI에서 3번째 인자값을 가져옵니다.
		$step = (int)$this->uri->segment(3);

		switch($step)
		{
			case 1:
				// GameStudio가 설치되어 있으면 다른 페이지(?)를 출력합니다
				if($this->Installmodel->is_installed())
				{
					//exit;
				}

				return $this->index();
			case 2:

				// GameStudio가 설치되어 있으면 오류를 출력합니다
				if($this->Installmodel->is_installed())
				{
					show_error('GameStudio가 이미 설치되어 있습니다.');
				}

				$data = array(
					'step' => $step,
					'permission' => is_writable(APPPATH . 'files'),
					'php_supported' => version_compare(PHP_VERSION, '5.2.0', '>='),
					'mysql_supported' => function_exists('mysql_connect'),
					'curl_supported' => function_exists('curl_init'),
					'base_url' => $this->config->item('base_url'),
				);

				// 설치되어 있지 않으면 설치 화면을 보여줍니다
				$this->load->view('install/install_page_step_2', $data);

				break;
			/**
			 * 3단계 : DB 정보 입력
			 */
			case 3:
				// GameStudio가 설치되어 있으면 오류를 출력합니다
				if($this->Installmodel->is_installed())
				{
					show_error('GameStudio가 이미 설치되어 있습니다.');
				}

				$data = array(
					'step' => $step,
					'permission' => is_writable(APPPATH . 'files'),
					'base_url' => $this->config->item('base_url'),
				);

				// 설치되어 있지 않으면 설치 화면을 보여줍니다
				$this->load->view('install/install_page_step_3', $data);
				break;
			case 4:
				$data = array(
					'step' => $step,
					'base_url' => $this->config->item('base_url'),
				);

				$this->load->view('install/install_page_step_4', $data);
				break;
		}
	}

	public function procSaveDBInfo()
	{
		$this->load->helper('url');

		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			redirect($this->config->item('base_url'), 'location', 301);
		}

		if(!isset($_POST['db_hostname']))
		{
			show_error('DB 호스트네임을 입력해주세요.');
		}

		if(!isset($_POST['db_port']))
		{
			show_error('DB Port를 입력해주세요.');
		}

		if(!isset($_POST['db_userid']))
		{
			show_error('DB 아이디를 입력해주세요.');
		}

		if(!isset($_POST['db_password']))
		{
			show_error('DB 비밀번호를 입력해주세요.');
		}

		if(!isset($_POST['db_database']))
		{
			show_error('DB 이름을 입력해주세요.');
		}

		$db_hostname = addslashes(trim($_POST['db_hostname']));
		$db_port = (int)$_POST['db_port'];
		$db_userid = addslashes(trim($_POST['db_userid']));
		$db_password = addslashes(trim($_POST['db_password']));
		$db_database = addslashes(trim($_POST['db_database']));

		if(!$db_hostname)
		{
			show_error('DB 호스트네임을 입력해주세요.');
		}

		if(!$db_port)
		{
			show_error('DB Port를 입력해주세요.');
		}

		if(!$db_userid)
		{
			show_error('DB 아이디를 입력해주세요.');
		}

		if(!$db_password)
		{
			show_error('DB 비밀번호를 입력해주세요.');
		}

		if(!$db_database)
		{
			show_error('DB 이름을 입력해주세요.');
		}

		$this->load->helper('file');

		$configFile = "<?php if(!defined('APPAPTH')) exit;\n\n\$config = array();\n";
		$configFile .= "\$config['hostname'] = '$db_hostname';\n";
		$configFile .= "\$config['username'] = '$db_userid';\n";
		$configFile .= "\$config['password'] = '$db_password';\n";
		$configFile .= "\$config['database'] = '$db_database';\n";
		$configFile .= "\$config['dbdriver'] = 'mysql';\n";
		$configFile .= "\$config['pconnect'] = FALSE;\n";
		$configFile .= "\$config['db_debug'] = TRUE;\n";
		$configFile .= "\$config['cache_on'] = FALSE;\n";
		$configFile .= "\$config['cachedir'] = '';\n";
		$configFile .= "\$config['char_set'] = 'utf8';\n";
		$configFile .= "\$config['dbcollat'] = 'utf8_general_ci';\n?>";

		if(!is_dir(APPPATH .'files/config'))
		{
			mkdir(APPPATH . 'files/config/', 0707);
		}

		if(!write_file(APPPATH . 'files/config/db.config.php', $configFile))
		{
			show_error('DB 설정 파일을 생성하지 못했습니다. application/files 폴더에 쓰기 권한이 있는지 확인해주세요.');
		}

		$this->load->model('installmodel');

		// DB 설정을 불러옵니다
		$this->installmodel->load_db_config();

		// DB에 접속합니다.
		$this->load->database($config);

		// DB 파일 생성 후 이동할 페이지
		$returnUrl = base_url('install/step/4/');

		redirect($returnUrl);
	}

	public function procInstall()
	{
		$this->load->dbforge();

		//Apps 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('apps'))
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'app_name' => array('type' => 'varchar', 'constraint' => 250)
			));

			$this->dbforge->create_table('apps', TRUE);
		}
	}

	/**
	 * 설치 초기화
	 */
	public function reset()
	{
		$this->load->view('install/reset_page');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */