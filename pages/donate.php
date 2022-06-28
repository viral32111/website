<?php

exit( 'This page is undergoing maintenance. Try again in a few days.' );

// Set the error handlers
//include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'Donate';

// Fetch the donations from the database
$databaseConnection = mysqli_connect( '', '', '', '', 3306 );
$donations = [];
$steamDonatorIDs = [];
$discordDonatorIDs = [];

// Fetch the legacy donations
$legacyResult = mysqli_query( $databaseConnection, 'SELECT SteamID, PackageName, Amount, Fee, UNIX_TIMESTAMP( Date ) AS Occured, Public FROM LegacyDonations;' );
while ( $row = mysqli_fetch_assoc( $legacyResult ) ) {
	$isPublic = intval( $row[ 'Public' ] );
	$steamID = intval( $row[ 'SteamID' ] );

	array_push( $donations, [
		'steam' => $steamID,
		'package' => $row[ 'PackageName' ],
		'amount' => floatval( $row[ 'Amount' ] ),
		'fee' => floatval( $row[ 'Fee' ] ),
		'occured' => $row[ 'Occured' ],
		'public' => $isPublic
	] );

	if ( $isPublic === 1 && in_array( $steamID, $steamDonatorIDs ) === false ) array_push( $steamDonatorIDs, $steamID );
}
mysqli_free_result( $legacyResult );

// Fetch the modern donations
$modernResult = mysqli_query( $databaseConnection, 'SELECT Discord, Amount, Fee, UNIX_TIMESTAMP( Occured ) AS Occured, Public FROM Donations;' );
while ( $row = mysqli_fetch_assoc( $modernResult ) ) {
	$isPublic = intval( $row[ 'Public' ] );
	$discordID = intval( $row[ 'Discord' ] );

	array_push( $donations, [
		'discord' => $discordID,
		'amount' => floatval( $row[ 'Amount' ] ),
		'fee' => floatval( $row[ 'Fee' ] ),
		'occured' => $row[ 'Occured' ],
		'public' => $isPublic
	] );

	if ( $isPublic === 1 && in_array( $discordID, $discordDonatorIDs ) === false ) array_push( $discordDonatorIDs, $discordID );
}
mysqli_free_result( $modernResult );

// Disconnect from the database
mysqli_close( $databaseConnection );

// Sort the donations by the date they occured
$occured = array_column( $donations, 'occured' );
array_multisort( $occured, SORT_DESC, $donations );

// Set the cache paths
$steamCachePath = '/tmp/donator-steam-usernames.json';
$discordCachePath = '/tmp/donator-discord-usernames.json';

// Read from the Steam cache
if ( is_file( $steamCachePath ) === true && ( time() - filemtime( $steamCachePath ) ) < 86400 ) {
	$steamCache = fopen( $steamCachePath, 'r' );
	$steamIDToName = json_decode( fread( $steamCache, filesize( $steamCachePath ) ), true );
	fclose( $steamCache );

// Write to the Steam cache
} else {
	$steamKey = '';

	$steamIDs = implode( ',', $steamDonatorIDs );
	$steamRequest = curl_init( 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=' . $steamKey . '&steamids=' . $steamIDs );
	curl_setopt( $steamRequest, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $steamRequest, CURLOPT_USERAGENT, 'viral32111 \'s website (https://viral2111.com; contact@viral32111.com)' );
	curl_setopt( $steamRequest, CURLOPT_TIMEOUT, 2 );
	$steamResponse = curl_exec( $steamRequest );
	$steamIDToName = [];
	$players = json_decode( $steamResponse, true )[ 'response' ][ 'players' ];
	foreach ( $players as $player ) {
		$steamIDToName[ intval( $player[ 'steamid' ] ) ] = $player[ 'personaname' ];
	}
	curl_close( $steamRequest );

	$steamCache = fopen( $steamCachePath, 'w' );
	fwrite( $steamCache, json_encode( $steamIDToName ) );
	fclose( $steamCache );
}

// Read from the Discord cache
if ( is_file( $discordCachePath ) === true && ( time() - filemtime( $discordCachePath ) ) < 86400 ) {
	$discordCache = fopen( $discordCachePath, 'r' );
	$discordIDToName = json_decode( fread( $discordCache, filesize( $discordCachePath ) ), true );
	fclose( $discordCache );

// Write to the Discord cache
} else {
	$discordBotToken = '';
	$discordIDToName = [];

	foreach ( $discordDonatorIDs as $discordID ) {
		$discordRequest = curl_init( 'https://discord.com/api/v8/users/' . $discordID );
		curl_setopt( $discordRequest, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $discordRequest, CURLOPT_USERAGENT, 'viral32111 \'s website (https://viral2111.com; contact@viral32111.com)' );
		curl_setopt( $discordRequest, CURLOPT_TIMEOUT, 2 );
		curl_setopt( $discordRequest, CURLOPT_HTTPHEADER, [ 'Authorization: Bot ' . $discordBotToken ] );
		$discordResponse = curl_exec( $discordRequest );
		$discordIDToName[ $discordID ] = json_decode( $discordResponse, true )[ 'username' ];
		curl_close( $discordRequest );
	}

	$discordCache = fopen( $discordCachePath, 'w' );
	fwrite( $discordCache, json_encode( $discordIDToName ) );
	fclose( $discordCache );
}

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<!-- Head -->
		<?php include( 'templates/head.php' ); ?>
	</head>
	<body>
		<!-- Header -->
		<?php include( 'templates/header.php' ); ?>

		<!-- Content -->
		<main>
			<p>I appreciate all the support I get, so if you would like to spare a bit of money and help me out then feel free to do so :D</p>
			<p>I currently only accept Monero and Bitcoin donations, you can find my address <a href="/xmr">here</a> for Monero, and <a href="/btc">here</a> for Bitcoin.</p>
			<h1 class="donation-title">History of Donations</h1>
			<table>
				<tr>
					<th>From</th>
					<th>Package</th>
					<th>Amount</th>
					<th>Date & Time</th>
				</tr>
				<?php foreach ( $donations as $donation ) {
					echo( "<tr>\n" );
					if ( $donation[ 'public' ] === 1 ) {
						if ( isset( $donation[ 'package' ] ) === true ) {
							echo( '<td>' . $steamIDToName[ $donation[ 'steam' ] ] . "</td>\n" );
						} else {
							echo( '<td>' . $discordIDToName[ $donation[ 'discord' ] ] . "</td>\n" );
						}
					} else {
						echo( "<td class=\"donation-private\" title=\"Redacted for donator privacy.\">Private</td>\n" );
					}
					if ( empty( $donation[ 'package' ] ) !== true ) {
						echo( '<td>' . $donation[ 'package' ] . "</td>\n" );
					} else {
						echo( "<td class=\"donation-none\">None</td>\n" );
					}
					echo( '<td title="Actual amount is ' . number_format( $donation[ 'amount' ] - $donation[ 'fee' ], 2 ) . ' GBP due to ' . number_format( $donation[ 'fee' ], 2 ) . ' GBP fee.">' . number_format( $donation[ 'amount' ], 2 ) . " GBP</td>\n" );
					echo( '<td>' . date( 'jS F Y, G:i:s e', $donation[ 'occured' ] ) . "</td>\n" );
					echo( "</tr>\n" );
				}
				?>
			</table>
			<p class="donation-note">Usernames are refreshed every 24 hours & your donation will not show until verified.</p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
