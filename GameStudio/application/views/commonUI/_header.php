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
	<title><?php if(isset($this->browser_title)) { echo $this->browser_title; } ?></title>
	<link rel="stylesheet" href="<?php echo $base_url; ?>application/third_party/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>application/third_party/bootstrap/css/bootstrap-responsive.min.css">
<?php
		if(count($this->_loaded_css_files) > 0) {	
			foreach($this->_loaded_css_files as $cssfile => $val) {
?>
	<link rel="stylesheet" href="<?php echo $cssfile; ?>" media="<?php echo $val['media']; ?>">
<?php
			}
		}

		if(count($this->_loaded_js_files) > 0) {	
			foreach($this->_loaded_js_files as $jsfile => $val) {
?>
	<script src="<?php echo $jsfile; ?>"></script>
<?php
			}
		}
?>
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