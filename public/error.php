<?php

echo( '<pre>' );
echo( 'REDIRECT_STATUS: ' . $_SERVER[ 'REDIRECT_STATUS' ] . "\n" );
echo( 'REDIRECT_REQUEST_METHOD: ' . $_SERVER[ 'REDIRECT_REQUEST_METHOD' ] . "\n" );
echo( 'REDIRECT_SCRIPT_URL: ' . $_SERVER[ 'REDIRECT_SCRIPT_URL' ] . "\n" );
echo( 'REQUEST_URI: ' . $_SERVER[ 'REQUEST_URI' ] . "\n" );
echo( '</pre><hr><pre>' );
var_dump( $_SERVER );
echo( '</pre>' );

?>
