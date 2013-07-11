<?php
class Member extends CI_Controller
{
	public function index()
	{
	}

	/**
	 * 회원 가입 페이지
	* @access public
	* @return void
	 */
	public function join()
	{
		$this->load->cssFile('./application/css/member.css');

		$this->load->view('commonUI/_header');
		$this->load->view('member/join');
		$this->load->view('commonUI/_footer');
	}

	public function login()
	{
		$this->load->helper('error');

		if($this->load->get_var('is_logged'))
		{
			show_custom_error('이미 로그인하셨습니다.', 200, 'common/error_general', 'Error!');
		}

		$_COOKIE['returnUrl'] = $_SERVER['REQUEST_URI'];

		$this->load->cssFile('./application/css/member.css');

		$this->load->view('commonUI/_header');
		$this->load->view('member/login');
		$this->load->view('commonUI/_footer');
	}

	/**
	 * 로그인을 시도합니다.
	 * @access public
	 * @return void
	 */
	public function procLogin()
	{
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			show_error('로그인을 할 수 없습니다.');
		}

		$user_id = trim($this->input->post('user_id'));
		$password = trim($this->input->post('password'));

		$this->load->helper('html');

		$this->db->select('*')->from('members')->where('user_id', $user_id);
		$query = $this->db->get(); 

		if(!isset($_COOKIE['returnUrl']))
		{
			$_COOKIE['returnUrl'] = '';
		}

		if($query->num_rows() < 1)
		{
			htmlHeader();
			alertScript('존재하지 않는 아이디입니다.');
			if($_COOKIE['returnUrl'])
			{
				locationHref($_COOKIE['returnUrl']);
				$_COOKIE['returnUrl'] = '';
			}
			htmlFooter();
			exit();
		}

		$row = $query->row(0);
		if($row->password != sha1(md5($password)))
		{
			htmlHeader();
			alertScript('잘못된 비밀번호입니다.');
			if($_COOKIE['returnUrl'])
			{
				locationHref($_COOKIE['returnUrl']);
				$_COOKIE['returnUrl'] = '';
			}
			htmlFooter();
			exit();
		}

		if($_COOKIE['returnUrl'])
		{
			$returnUrl = $_COOKIE['returnUrl'];
			$_COOKIE['returnUrl'] = '';
		}

		if(!isset($returnUrl) || !$returnUrl)
		{
			$returnUrl = site_url();
		}

		$_SESSION['is_logged'] = true;
		$_SESSION['member_no'] = $row->member_no;
		$_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];

		redirect($returnUrl);
	}

	public function procJoin()
	{
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			show_error('회원 가입을 할 수 없습니다.');
		}

		$this->load->helper('html');


		if(!isset($_POST['user_id']))
		{
			htmlHeader();
			alertScript('아이디를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		if(!isset($_POST['password']))
		{
			htmlHeader();
			alertScript('비밀번호를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		if(!isset($_POST['nick_name']))
		{
			show_error('닉네임을 입력해주세요.');
		}

		if(!isset($_POST['email_address']))
		{
			show_error('이메일 주소를 입력해주세요.');
		}

		$user_id = trim($_POST['user_id']);
		if(!$user_id)
		{
			htmlHeader();
			alertScript('아이디를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		$nick_name = trim($_POST['nick_name']);
		if(!$nick_name)
		{
			htmlHeader();
			alertScript('닉네임을 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}
		$password = trim($_POST['password']);
		if(!$password)
		{
			htmlHeader();
			alertScript('비밀번호를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		$email_address = trim($_POST['email_address']);
		if(!$email_address)
		{
			htmlHeader();
			alertScript('이메일 주소를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		// email 헬퍼를 불러들입니다
		$this->load->helper('email');

		// 유효한 메일 주소인지 확인합니다
		if(!valid_email($email_address))
		{

			htmlHeader();
			alertScript('올바른 이메일 주소를 입력해주세요.', TRUE);
			htmlFooter();
			return;
		}

		// 이메일 주소에서 ID와 도메인을 분리합니다.
		list($email_id, $email_host) = explode('@', $email_address);

		// DB 설정을 불러옵니다
		include (APPPATH . 'files/config/db.config.php');

		// DB에 접속합니다.
		$this->load->database($db_info);

		$memberInfo = array(
			'user_id' => $user_id,
			'nick_name' => $nick_name,
			'password' => sha1(md5($password)),
			'email_address' => $email_address,
			'email_id' => $email_id,
			'email_host' => $email_host,
			'joindate' => date('YmdHis')
		);

		$this->db->insert('members', $memberInfo);
	}
}