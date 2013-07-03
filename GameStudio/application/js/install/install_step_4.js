$(document).ready(function(){
	$('#adminSetup').submit(function(){
		if(!$(this).find('input[name=user_id]').val()) {
			alert('아이디를 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=password]').val()) {
			alert('비밀번호를 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=nick_name]').val()) {
			alert('닉네임을 입력해주세요.');
			return false;
		}

		if(!$(this).find('input[name=email_address]').val()) {
			alert('메일 주소를 입력해주세요.');
			return false;
		}
	});
});