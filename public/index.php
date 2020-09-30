<?php

// Include necessary files
require_once( '../private/include/session.php' );

sleep( 10 );

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Home</title>
	</head>
	<body>
		<p>This is an amazing website!</p>
		<hr><pre><?php var_dump( $_GET ); ?></pre>
		<hr><pre><?php var_dump( $_POST ); ?></pre>
		<hr><pre><?php var_dump( $_FILES ); ?></pre>
		<hr><pre><?php var_dump( $_COOKIE ); ?></pre>
		<hr><pre><?php var_dump( $_SESSION ); ?></pre>
		<hr><pre><?php var_dump( $_REQUEST ); ?></pre>
		<hr><pre><?php var_dump( $_ENV ); ?></pre>
		<hr><pre><?php var_dump( $_SERVER ); ?></pre>
	</body>
</html>
