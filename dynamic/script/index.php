<?php

$pagesDirectory = $_SERVER[ "DOCUMENT_ROOT" ] . "/pages";

function showErrorPage( int $statusCode, string $message = null ) {
	header( "Content-Type: text/plain" );
	http_response_code( $statusCode );

	if ( !empty( $message ) ) {
		error_log( $message );
		exit( $message );
	}
}

function parseMarkdownToHTML( string $markdownContent ) : string {
	$markdownLines = explode( "\n", $markdownContent );
	$parsedHTML = "";

	foreach ( $markdownLines as $markdownLine ) {

		if ( empty( $markdownLine ) ) continue;

		if ( strncmp( $markdownLine, "# ", 2 ) === 0 ) {
			$title = trim( substr( $markdownLine, 2 ) );
			$parsedHTML .= "<h1>" . $title . "</h1>\n";

		} elseif ( strncmp( $markdownLine, "## ", 3 ) === 0 ) {
			$title = trim( substr( $markdownLine, 3 ) );
			$parsedHTML .= "<h2>" . $title . "</h2>\n";

		} elseif ( strncmp( $markdownLine, "### ", 4 ) === 0 ) {
			$title = trim( substr( $markdownLine, 4 ) );
			$parsedHTML .= "<h3>" . $title . "</h3>\n";

			

		} else {
			$markdownLine = preg_replace( '/\*\*(.+?)\*\*/', '<strong>${1}</strong>', $markdownLine );
			$markdownLine = preg_replace( '/\*(.+?)\*/', '<em>${1}</em>', $markdownLine );
			$markdownLine = preg_replace( '/`(.+?)`/', '<code>${1}</code>', $markdownLine );
			$markdownLine = preg_replace( '/\[(.+?)\]\((.+?)\)/', '<a href="${2}">${1}</a>', $markdownLine );

			$parsedHTML .= "<p>" . $markdownLine . "</p>\n";
		}

	}

	return $parsedHTML;
}

$pageName = $_GET[ "page" ];
if ( empty( $pageName ) ) showErrorPage( 400, "No page specified." );

$pageFileName = $pageName . ".md";
if ( !is_file( $pagesDirectory . "/" . $pageFileName ) ) showErrorPage( 404, "Specified page does not exist." );

ob_start();
require( $pagesDirectory . "/" . $pageFileName );
$pageContent = ob_get_clean();

$pageHTML = parseMarkdownToHTML( $pageContent );

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?= $pageName ?></title>
		<meta charset="utf-8">
		<style>
			body {
				font-family: 'Verdana';
				font-size: 13px;
			}
		</style>
	</head>
	<body>
		<?= $pageHTML ?>
	</body>
</html>
