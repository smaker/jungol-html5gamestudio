$(document).ready(function(){
	$('#install').submit(function(){
		if(!$(this).find('input[name=db_hostname]').val()) {
			alert('DB 호스트네임을 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=db_port]').val()) {
			alert('DB Port를 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=db_userid]').val()) {
			alert('DB 아이디를 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=db_password]').val()) {
			alert('DB 비밀번호를 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=db_database]').val()) {
			alert('DB 이름을 입력해주세요.');
			return false;
		}
	});
});