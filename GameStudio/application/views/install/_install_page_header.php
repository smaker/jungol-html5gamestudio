<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<title>GameStudio 설치</title>
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
	<script>
	var default_url = '<?php echo base_url(); ?>';
	</script>
</head>
<body>
	<div class="navbar navbar-fixed-top navbar-inverse">
		<div class="navbar-inner">
			<a class="brand" href="<?php echo $base_url; ?>install/"><span class="text-white">Game</span><span class="text-red">Studio</span> 설치</a>
		</div>
	</div>
	<div class="container" style="margin-top:41px;">