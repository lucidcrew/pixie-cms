<?php if (!defined('BB2_CORE')) die('I said no cheating!');

// Functions called when a request has been denied
// This part can be gawd-awful slow, doesn't matter :)

require_once(BB2_CORE . "/responses.inc.php");

function bb2_display_denial($settings, $key, $previous_key = false)
{
	if (!$previous_key) $previous_key = $key;
	if ($key == "e87553e1") {
		// FIXME: lookup the real key
	}
	// Create support key
	$ip = explode(".", $_SERVER['REMOTE_ADDR']);
	$ip_hex = "";
	foreach ($ip as $octet) {
		$ip_hex .= str_pad(dechex($octet), 2, 0, STR_PAD_LEFT);
	}
	$support_key = implode("-", str_split("$ip_hex$key", 4));

	// Get response data
	$response = bb2_get_response($previous_key);
	header("HTTP/1.1 " . $response['response'] . " Bad Behavior");
	header("Status: " . $response['response'] . " Bad Behavior");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>HTTP Error <?php echo $response['response']; ?></title>
	<style type="text/css">
		body
			{
			font-family: Arial, 'Lucida Grande', Verdana, Sans-Serif;
			color: #333;
			}
		
		a, a:visited
			{
			text-decoration: none;
			color: #0497d3;
			}

		a:hover
			{
			color: #191919;
			text-decoration: none;
			}
			
		.helper
			{
			position: relative;
			top: 60px;
			border: 5px solid #e1e1e1;
			clear: left;
			padding: 15px 30px;
			margin: 0 auto;
			background-color: #F0F0F0;
			width: 500px;
			line-height: 15pt;
			}
	</style>
</head>
<body>
<div class="helper">
<h3>Error <?php echo $response['response']; ?></h3>
<p>We're sorry, but <a href="http://www.getpixie.co.uk" alt="Get Pixie!">Pixie</a> could not fulfill your request for
<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?> on this server.</p>
<p><?php echo $response['explanation']; ?></p>
<p>Your technical support key is: <strong><?php echo $support_key; ?></strong></p>
<p>You can use this key to <a href="http://www.ioerror.us/bb2-support-key?key=<?php echo $support_key; ?>">fix this problem yourself</a>.</p>
<p>If you are unable to fix the problem yourself, please contact <a href="mailto:<?php echo htmlspecialchars(str_replace("@", "+nospam@nospam.", bb2_email())); ?>"><?php echo htmlspecialchars(str_replace("@", " at ", bb2_email())); ?></a> and be sure to provide the technical support key shown above.</p>
</div>
<?php
}

function bb2_log_denial($settings, $package, $key, $previous_key=false)
{
	if (!$settings['logging']) return;
	bb2_db_query(bb2_insert($settings, $package, $key));
}

?>
</body>
</html>