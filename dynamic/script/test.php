<?php

require_once( 'cache.php' );

header( 'Content-Type: text/plain' );

var_dump( Cache::GetSteamProfileNames( [
	'76561198168833275', // viral32111
	'76561198145551898', // alex_1001
	'76561198803067377' // Ruby Rose
] ) );

echo( "\n" );

var_dump( Cache::GetDiscordUserNames( [
	'480764191465144331', // viral32111
	'205408309019148289', // weebi
	'431572454679511050' // josh
] ) );

?>
