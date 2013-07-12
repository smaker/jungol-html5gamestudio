<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	/**
	 * 설치 화면
	 * @access public
	 * @return void
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
	 * 각 단계별 설치 과정
	 * @access public
	 * @return void
	 */
	public function step()
	{
		$this->load->cssFile('http://fonts.googleapis.com/earlyaccess/nanumgothic.css');
		$this->load->cssFile('./application/css/install.css');
		$this->load->cssFile('./application/third_party/bootstrap/css/bootstrap.min.css');
		$this->load->cssFile('./application/third_party/bootstrap/css/bootstrap-responsive.min.css');
		$this->load->jsFile('./application/third_party/jquery/jquery-1.10.0.min.js');

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

		$db_hostname = addslashes(trim($this->input->post('db_hostname')));
		$db_port = (int)$this->input->post('db_port');
		$db_userid = addslashes(trim($this->input->post('db_userid')));
		$db_password = addslashes(trim($this->input->post('db_password')));
		$db_database = addslashes(trim($this->input->post('db_database')));
		$db_prefix = addslashes(trim($this->input->post('db_prefix')));

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

		$configFile = "<?php if(!defined('APPPATH')) exit;\n\$db_info = array(\n";
		$configFile .= "\t'hostname' => '$db_hostname',\n";
		$configFile .= "\t'username' => '$db_userid',\n";
		$configFile .= "\t'password' => '$db_password',\n";
		$configFile .= "\t'database' => '$db_database',\n";
		$configFile .= "\t'dbdriver' => 'mysql',\n";
		$configFile .= "\t'dbprefix' => '$db_prefix',\n";
		$configFile .= "\t'pconnect' => FALSE,\n";
		$configFile .= "\t'db_debug' => TRUE,\n";
		$configFile .= "\t'cache_on' => FALSE,\n";
		$configFile .= "\t'cachedir' => '',\n";
		$configFile .= "\t'char_set' => 'utf8',\n";
		$configFile .= "\t'dbcollat' => 'utf8_general_ci',\n";
		$configFile .= "\t'port' => $db_port\n";
		$configFile .= ");";

		if(!is_dir(APPPATH .'files/config'))
		{
			mkdir(APPPATH . 'files/config/', 0707);
		}

		if(!write_file(APPPATH . 'files/config/db.config.php', $configFile))
		{
			show_error('DB 설정 파일을 생성하지 못했습니다. application/files 폴더에 쓰기 권한이 있는지 확인해주세요.');
		}

		// DB 설정을 불러옵니다
		include (APPPATH . 'files/config/db.config.php');

		// DB에 접속합니다.
		$this->load->database($db_info);

		$this->load->dbforge();

		// Projects 테이블이 생성되어 있지 않으면 생성합니다
		$this->dbforge->add_field(array(
			'project_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'project_name' => array('type' => 'VARCHAR', 'constraint' => 250),
			'canvas_width' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'canvas_height' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'regdate' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'last_update' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'description' => array('type' => 'VARCHAR', 'constraint' => 250)
		));

		$this->dbforge->add_key('project_id', TRUE);
		$this->dbforge->add_key('regdate');
		$this->dbforge->add_key('last_update');

		$this->dbforge->create_table('projects', TRUE);

		// Project_events 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('project_events'))
		{
			$this->dbforge->add_field(array(
				'project_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'event_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'event_type' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'list_order' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'regdate' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			));
			$this->dbforge->add_key('project_id');
			$this->dbforge->add_key('regdate');
			$this->dbforge->add_key('list_order');
			$this->dbforge->create_table('project_events', TRUE);
			$this->db->query("CREATE UNIQUE INDEX idx_event ON {$db_prefix}project_events(project_id, event_id)");
		}

		// Project_events 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('project_actions'))
		{
			$this->dbforge->add_field(array(
				'project_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'event_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'action_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'action_type' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'list_order' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'regdate' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			));

			$this->dbforge->add_key('project_id');
			$this->dbforge->add_key('regdate');
			$this->dbforge->add_key('list_order');
			$this->dbforge->create_table('project_actions', TRUE);
			$this->db->query("CREATE UNIQUE INDEX idx_action ON {$db_prefix}project_actions(project_id, event_id, action_id)"); 

		}

		// Apps 테이블이 생성되어 있지 않으면 생성합니다
		$this->dbforge->add_field(array(
			'app_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'app_name' => array('type' => 'VARCHAR', 'constraint' => 250),
			'rated_count' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'rating_score' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'comment_count' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
			'description' => array('type' => 'VARCHAR', 'constraint' => 250)
		));

		$this->dbforge->add_key('app_id', TRUE);
		$this->dbforge->add_key('rated_count');
		$this->dbforge->add_key('rating_score');
		$this->dbforge->add_key('comment_count');

		$this->dbforge->create_table('apps', TRUE);

		// App_comments 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('app_comments'))
		{
			$this->dbforge->add_field(array(
				'app_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'comment_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'member_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'nick_name' => array('type' => 'VARCHAR', 'constraint' => 100),
				'content' => array('type' => 'VARCHAR', 'constraint' => 250),
				'rating_score' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'regdate' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE)
			));

			$this->dbforge->add_key('app_id');
			$this->dbforge->add_key('regdate');

			$this->dbforge->create_table('app_comments', TRUE);
			$this->db->query("CREATE UNIQUE INDEX idx_comment ON {$db_prefix}app_comments(app_id, comment_id)");
		}


		// App_datas 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('app_datas'))
		{
			$this->dbforge->add_field(array(
				'app_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
				'member_no' => array('type' => 'INT', 'constraint' => 11, 'unsinged' => TRUE),
				'data' => array('type' => 'TEXT')
			));

			$this->dbforge->create_table('app_datas', TRUE);
			$this->db->query("CREATE UNIQUE INDEX idx_app_data ON {$db_prefix}app_datas(app_id, member_no)"); 
		}

		// Members 테이블이 생성되어 있지 않으면 생성합니다
		if (!$this->db->table_exists('members'))
		{
			$this->dbforge->add_field(array(
				'member_no' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'user_id' => array('type' => 'varchar', 'constraint' => 250),
				'password' => array('type' => 'varchar', 'constraint' => 250),
				'email_address' => array('type' => 'varchar', 'constraint' => 250),
				'email_id' => array('type' => 'varchar', 'constraint' => 250),
				'email_host' => array('type' => 'varchar', 'constraint' => 250),
				'nick_name' => array('type' => 'varchar', 'constraint' => 50),
				'joindate' => array('type' => 'INT', 'constraint' => 11)
			));

			$this->dbforge->add_key('member_no', TRUE);
			$this->dbforge->add_key('user_id');
			$this->dbforge->add_key('joindate');

			$this->dbforge->create_table('members', TRUE);
			$this->db->query("CREATE UNIQUE INDEX unique_user_id ON {$db_prefix}members(user_id)"); 
			$this->db->query("CREATE UNIQUE INDEX unique_email_address ON {$db_prefix}members(email_address)"); 
			$this->db->query("CREATE UNIQUE INDEX unique_nick_name ON {$db_prefix}members(nick_name)"); 
		}

		// DB 파일 생성 후 이동할 페이지
		$returnUrl = base_url('install/step/4/');

		redirect($returnUrl);
	}

	public function procSaveAdminInfo()
	{
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			show_error('정상적인 방법으로 접근해주세요.');
		}

		$this->load->helper('html');

		$user_id = trim($this->input->post('user_id'));
		if(!$user_id)
		{
			show_error('아이디를 입력해주세요.');
		}

		$password = trim($this->input->post('password'));
		if(!$password)
		{
			show_error('비밀번호를 입력해주세요.');
		}

		$nick_name = trim($this->input->post('nick_name'));
		if(!$nick_name)
		{
			show_error('닉네임을 입력해주세요.');
		}

		$email_address = trim($this->input->post('email_address'));
		if(!$email_address)
		{
			show_error('이메일 주소를 입력해주세요.');
		}

		// DB 설정을 불러옵니다
		include (APPPATH . 'files/config/db.config.php');

		// DB에 접속합니다.
		$this->load->database($db_info);

		$memberInfo = array(
			'user_id' => $user_id,
			'password' => sha1(md5($password)),
			'nick_name' => $nick_name,
			'email_address' => $email_address,
			'email_id' => $email_id,
			'email_host' => $email_host,
			'joindate' => date('YmdHis')
		);

		$this->db->insert('members', $memberInfo);

		// 관리자 정보 입력 후 이동할 페이지
		$returnUrl = base_url('install/complete/');

		redirect($returnUrl);
	}

	public function complete()
	{
		// View 파일에서 사용할 변수 정의
		$data = array(
			'base_url' => $this->config->item('base_url'),
		);

		$this->load->cssFile('http://fonts.googleapis.com/earlyaccess/nanumgothic.css');
		$this->load->cssFile('./application/third_party/bootstrap/css/bootstrap.min.css');
		$this->load->cssFile('./application/third_party/bootstrap/css/bootstrap-responsive.min.css');
		$this->load->cssFile('./application/css/install.css');
		$this->load->jsFile('./application/third_party/jquery/jquery-1.10.0.min.js');


		$this->load->view('install/complete', $data);
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