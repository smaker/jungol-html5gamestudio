<?php include '_install_page_header.php'; ?>
		<h1>관리자 정보 입력</h1>
		<form id="adminSetup" action="<?php echo site_url('install/procSaveAdminInfo/'); ?>" method="post" class="form-horizonal">
			<div class="control-groups">
				<label class="control-label" for="user_id">아이디</label>
				<div class="controls">
					<input type="text" id="user_id" name="user_id" value="" placeholder="아이디" data-itemname="아이디" required>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="password">비밀번호</label>
				<div class="controls">
					<input type="text" id="password" name="password" value="" placeholder="비밀번호" data-itemname="비밀번호" required>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="nick_name">닉네임</label>
				<div class="controls">
					<input type="text" id="nick_name" name="nick_name" value="" placeholder="닉네임" data-itemname="닉네임" required>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="email_address">메일 주소</label>
				<div class="controls">
					<input type="text" id="email_address" name="email_address" value="" placeholder="메일 주소" data-itemname="메일 주소" required>
				</div>
			</div>
			<div class="control-groups">
				<div class="controls">
					<a href="<?php echo site_url('install/step/3/'); ?>" class="btn"><i class="icon-chevron-left"></i> 이전</a>
					<button type="submit" class="btn btn-inverse">다음 <i class="icon-chevron-right icon-white"></i></button>
				</div>
			</div>
		</form>

		<div class="clearfix"></div>

<?php include '_install_page_footer.php'; ?>