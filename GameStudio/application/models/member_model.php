<?php
class member_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getMemberInfo($member_no = NULL)
	{
		if(!$member_no)
		{
			return array();
		}

		if(!isset($this->db))
		{
			if(is_readable(APPPATH . 'files/config/db.config.php'))
			{
				include (APPPATH . 'files/config/db.config.php');

				// DB에 접속합니다.
				$this->load->database($db_info);
			}
		}

		$this->db->select('*')->from('members')->where('member_no', $member_no);

		return $this->db->get()->row(0);
	}
}