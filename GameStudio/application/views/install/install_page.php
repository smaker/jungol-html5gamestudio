<?php include '_install_page_header.php'; ?>
		<h1>약관 동의</h2>
		<div class="well agreement">
			<?php echo $agreement; ?>
		</div>

		<input type="checkbox" name="agreement" id="chk_agreement" value="Y" checked> <label for="chk_agreement" style="display:inline-block">GNU 일반 공중 사용 허가서에 동의합니다.</label>

		<div class="text-center">
			<a href="<?php echo $base_url; ?>install/step/2" class="btn btn-success">다음 <i class="icon-chevron-right icon-white"></i></a>
		</div>

		<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
<?php include '_install_page_footer.php'; ?>