<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http');
$base_url .= '://' . $_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<title>Error</title>
	<link rel="stylesheet" href="<?php echo $base_url; ?>application/third_party/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>application/third_party/bootstrap/css/bootstrap-responsive.min.css">
</head>
<body>
	<div class="navbar navbar-fixed-top navbar-inverse">
		<div class="navbar-inner">
			<div class="container">
				<ul class="nav">
					<li>
						<a href="<?php echo $base_url; ?>login/">로그인</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container" style="margin-top:41px;">
		<div class="alert alert-info" style="margin-top:12px;">
		  GameStudio가 이미 설치되어 있습니다.
		 </div>
	</div>
</body>
</html>