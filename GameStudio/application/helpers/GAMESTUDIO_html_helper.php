<?php

/**
 * Print raw html header
 *
 * @return void
 */
function htmlHeader()
{
	echo <<<HTMLHEADER
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
</head>
<body>
HTMLHEADER;
}

/**
 * Print raw html footer
 *
 * @return void
 */
function htmlFooter()
{
	echo '</body></html>';
}

/**
 * Print raw alert message script
 *
 * @param string $msg
 * @return void
 */
function alertScript($msg, $historyBack = FALSE)
{
	if(!$msg)
	{
		return;
	}

	echo '<script>alert("' . $msg . '");</script>';

	if($historyBack)
	{
		echo '<script>history.back(-1);</script>';
	}
}

/**
 * Print raw close window script
 *
 * @return void
 */
function closePopupScript()
{
	echo '<script>window.close();</script>';
}

/**
 * Print raw reload script
 *
 * @param bool $isOpener
 * @return void
 */
function reload($isOpener = FALSE)
{
	$reloadScript = $isOpener ? 'window.opener.location.reload()' : 'document.location.reload()';

	echo '<script>' . $reloadScript . '</script>';
}