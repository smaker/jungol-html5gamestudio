<?php include '_install_page_header.php'; ?>
		<h1>설치 조건 확인</h1>
		<table class="table table-hover table-striped">
		<tr>
			<th>퍼미션</th>
			<td>
				<?php if(is_writeable(APPPATH.'files/')) { ?><img src="<?php echo site_url('application/img/tick.png')?>" width="16" height="16" alt=""> <span class="text-success">설정 완료</span><? } else { ?><img src="<?php echo site_url('application/img/cross.png')?>" width="16" height="16" alt=""> <span class="text-error">/application/files/ 폴더의 퍼미션을 707으로 변경해 주세요. (해당 폴더에 읽기/쓰기 권한이 필요합니다.)</span><? } ?>
			</td>
		</tr>
		<tr>
			<th>PHP</th>
			<td><?php if($php_supported) { ?><img src="<?php echo site_url('application/img/tick.png')?>" width="16" height="16" alt=""> <span class="text-success"><?php echo PHP_VERSION; ?></span><?php } else { ?><img src="<?php echo site_url('application/img/cross.png')?>" width="16" height="16" alt=""> <span class="text-error"><?php echo phpversion(); ?> (권장 버전 : 5.2 이상)</span><?php } ?></td>
		</tr>
		<tr>
			<th>MySQL</th>
			<td><?php if($mysql_supported) { ?><img src="<?php echo site_url('application/img/tick.png')?>" width="16" height="16" alt=""> <span class="text-success">지원</span><?php } else { ?><img src="<?php echo site_url('application/img/cross.png')?>" width="16" height="16" alt=""> <span class="text-error">MySQL 설치 필요</span><?php } ?></td>
		</tr>
		<tr>
			<th>cURL</th>
			<td><?php if($curl_supported) { ?><img src="<?php echo site_url('application/img/tick.png')?>" width="16" height="16" alt=""> <span class="text-success">지원</span><?php } else { ?><img src="<?php echo site_url('application/img/cross.png')?>" width="16" height="16" alt=""> <span class="text-warning">미지원</span><?php } ?></td>
		</tr>
		</table>

		<a href="<?php echo site_url('install/step/1/'); ?>" class="btn"><i class="icon-chevron-left"></i> 이전</a>
		<a href="<?php echo site_url('install/step/3/'); ?>"<?php if(!$php_supported || !$mysql_supported) { ?> onclick="return false;"<?php } ?> class="btn btn-inverse<?php if(!$php_supported || !$mysql_supported) { ?> btn-disabled<?php } ?>">다음 <i class="icon-chevron-right icon-white"></i></a>

		<div class="clearfix"></div>
<?php include '_install_page_footer.php'; ?>