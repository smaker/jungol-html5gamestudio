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
	<div class="container">
		<div class="hero-unit">
		  <h1><?php echo $heading; ?></h1>
		  <p><?php echo $message; ?></p>
		  <p>

		    <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo $_SERVER['HTTP_REFERER']; } else { ?>#<?php } ?>" onclick="history.back();" class="btn btn-large">
		      새로고침
		    </a>
		    <a href="<?php if(isset($_SERVER['HTTP_REFERER'])) { echo $_SERVER['HTTP_REFERER']; } else { ?>#<?php } ?>" onclick="history.back();" class="btn btn-primary btn-large">
		      돌아가기
		    </a>
		  </p>
	</div>
</body>
</html>