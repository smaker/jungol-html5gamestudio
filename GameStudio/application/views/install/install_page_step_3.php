<?php include '_install_page_header.php'; ?>
		<script src="<?php echo $base_url; ?>application/third_party/jquery/jquery-1.10.0.min.js"></script>
		<script src="<?php echo $base_url; ?>application/js/install.js"></script>

		<h1>MySQL 정보 입력</h1>
		<?php if(!$permission) { ?>
		<p class="alert">
			<strong>application/files/</strong> 폴더의 쓰기 권한이 없습니다.<br>
			해당 파일의 쓰기 권한을 확인해주세요.<br>
			(리눅스 서버의 경우 퍼미션을 707로 설정해야 합니다.)
		</p>
		<?php } ?>
		<form id="install" action="<?php echo site_url('install/procSaveDBInfo/'); ?>" method="post" class="form-horizonal">
			<div class="control-groups">
				<label class="control-label" for="db_hostname">DB 호스트네임</label>
				<div class="controls">
					<input type="text" id="db_hostname" name="db_hostname" value="localhost" placeholder="DB 호스트네임" title="DB 호스트네임" required<?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="db_port">DB Port</label>
				<div class="controls">
					<input type="number" id="db_port" name="db_port" value="3306" min="0" max="65535" placeholder="DB Port" title="DB Port"<?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="db_userid">DB 아이디</label>
				<div class="controls">
					<input type="text" id="db_userid" name="db_userid" value="" placeholder="DB 아이디" title="DB 아이디" required<?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="db_password">DB 비밀번호</label>
				<div class="controls">
					<input type="password" id="db_password" name="db_password" value="" placeholder="DB 비밀번호" title="DB 비밀번호" required<?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="db_prefix">테이블 머릿말</label>
				<div class="controls">
					<input type="text" id="db_prefix" name="db_prefix" value="gs_" placeholder="테이블 머릿말" title="테이블 머릿말" <?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<label class="control-label" for="db_database">DB 이름</label>
				<div class="controls">
					<input type="text" id="db_database" name="db_database" value="" placeholder="DB 이름" title="DB 이름" required<?php if(!$permission) { ?> disabled<?php } ?>>
				</div>
			</div>
			<div class="control-groups">
				<div class="controls">
					<a href="<?php echo site_url('install/step/2/'); ?>" class="btn"><i class="icon-chevron-left"></i> 이전</a>
					<button type="submit" class="btn btn-inverse"<?php if(!$permission) { ?> disabled<?php } ?>>다음 <i class="icon-chevron-right icon-white"></i></button>
				</div>
			</div>
		</form>

		<div class="clearfix"></div>
<?php include '_install_page_footer.php'; ?>