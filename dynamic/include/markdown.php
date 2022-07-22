<?php

// My library for converting Markdown to HTML

class MarkdownToHTML {

	public static function ConvertString( string $markdownString ) : string {

		$markdownLines = explode( PHP_EOL, $markdownString );
		$markdownLinesCount = count( $markdownLines );

		$htmlLines = [];

		for ( $lineNumber = 0; $lineNumber < $markdownLinesCount; $lineNumber++ ) {

			$markdownLine = $markdownLines[ $lineNumber ];

			// Some block-level conversions require context
			$precedingLines = array_slice( $markdownLines, 0, $lineNumber );
			$followingLines = array_slice( $markdownLines, $lineNumber + 1 );

			$lineChanged = false;

			//////////////// Block (only one per line) ////////////////

			// Headings
			[ $markdownLine, $headingChange ] = self::ConvertHeading( $markdownLine );

			// Lists
			[ $markdownLine, $unorderedListChange ] = self::ConvertUnorderedList( $markdownLine, $followingLines, $precedingLines );
			[ $markdownLine, $orderedListChange ] = self::ConvertOrderedList( $markdownLine, $followingLines, $precedingLines );

			// TODO: Table

			// Code Blocks
			[ $markdownLine, $codeBlockChange, $skipLines ] = self::ConvertCodeBlock( $markdownLine, $followingLines );

			if ( empty( $markdownLine ) ) continue;

			//////////////// Inline (many per line) ////////////////

			// Bold
			$markdownLine = preg_replace( '/\*\*(.+?)\*\*/', '<strong>${1}</strong>', $markdownLine );
				
			// Italic
			$markdownLine = preg_replace( '/\*(.+?)\*/', '<em>${1}</em>', $markdownLine );

			// Underline
			$markdownLine = preg_replace( '/__(.+?)__/', '<u>${1}</u>', $markdownLine );

			// Code
			$markdownLine = preg_replace( '/`(.+?)`/', '<code>${1}</code>', $markdownLine );

			// Images
			$markdownLine = preg_replace( '/!\[(.+?)\]\((.+?)\)/', '<img src="${2}" alt="${1}">', $markdownLine );

			// Self Links
			$markdownLine = preg_replace( '/\[(.+?)\]\((\/.+?)\)/', '<a href="${2}">${1}</a>', $markdownLine );

			// External Links
			// NOTE: Target opens in new tab, rel prevents new tabs from modifying the original tab
			$markdownLine = preg_replace( '/\[(.+?)\]\((.+?)\)/', '<a href="${2}" target="_blank" rel="noopener noreferrer">${1}</a>', $markdownLine );

			if ( $headingChange || $unorderedListChange || $orderedListChange || $codeBlockChange ) {
				array_push( $htmlLines, $markdownLine );
			} else {
				array_push( $htmlLines, "<p>$markdownLine</p>" );
			}

			// Some block-level values are multiple lines
			$lineNumber += $skipLines;
	
		}

		return join( "\n", array_filter( $htmlLines ) );
	
	}
	
	private static function ConvertHeading( string $markdownLine ) : array {
	
		for ( $count = 1; $count <= 6; $count++ ) {
			
			$prefix = str_repeat( "#", $count ) . " ";
			$prefixLength = strlen( $prefix );
	
			if ( strncmp( $markdownLine, $prefix, $prefixLength ) === 0 ) {
	
				$value = trim( substr( $markdownLine, $prefixLength ) );
	
				return [ "<h$count>$value</h$count>", true ];
	
			}
	
		}
	
		return [ $markdownLine, false ];
	
	}
	
	private static function ConvertUnorderedList( string $markdownLine, array $followingLines, array $precedingLines ) : array {

		$previousLine = ( count( $precedingLines ) > 0 ? $precedingLines[ count( $precedingLines ) - 1 ] : "" );
		$nextLine = ( count( $followingLines ) > 0 ? $followingLines[ 0 ] : "" );

		if ( strncmp( $markdownLine, "* ", 2 ) === 0 ) {

			$value = trim( substr( $markdownLine, 2 ) );

			return [ ( empty( $previousLine ) ? "<ul>\n" : "" ) . "<li>$value</li>" . ( empty( $nextLine ) ? "\n</ul>" : "" ), true ];

		}

		return [ $markdownLine, false ];
	
	}

	private static function ConvertOrderedList( string $markdownLine, array $followingLines, array $precedingLines ) : array {

		$previousLine = ( count( $precedingLines ) > 0 ? $precedingLines[ count( $precedingLines ) - 1 ] : "" );
		$nextLine = ( count( $followingLines ) > 0 ? $followingLines[ 0 ] : "" );

		if ( preg_match( '/^\d\. (.+)$/', $markdownLine, $listMatch ) === 1 ) {

			$value = trim( $listMatch[ 1 ] );

			return [ ( empty( $previousLine ) ? "<ol>\n" : "" ) . "<li>$value</li>" . ( empty( $nextLine ) ? "\n</ol>" : "" ), true ];
			
		}

		return [ $markdownLine, false ];
	
	}

	private static function ConvertCodeBlock( string $markdownLine, array $followingLines ) : array {

		if ( strncmp( $markdownLine, "```", 3 ) === 0 ) {

			$language = trim( substr( $markdownLine, 3 ) ); // Its okay if this is empty

			for ( $followingLineNumber = 0; $followingLineNumber < count( $followingLines ); $followingLineNumber++ ) {

				$followingLine = $followingLines[ $followingLineNumber ];

				if ( $followingLine === "```" ) {

					$codeLines = array_slice( $followingLines, 0, $followingLineNumber );
					$code = join( "\n", $codeLines );

					$code = self::EscapeTagSymbols( $code );

					return [ "<pre><code class=\"language-" . ( empty( $language ) ? "text" : $language ) . "\">$code</code></pre>", true, count( $codeLines ) + 2 ];

				}

			}

			throw new Exception( "Code block never ends." );

		}

		return [ $markdownLine, false, 0 ];

	}

	private static function EscapeTagSymbols( string $markdownLine ) : string { 

		// Open
		$markdownLine = preg_replace( '/</', '&lt;', $markdownLine );

		// Close
		$markdownLine = preg_replace( '/>/', '&gt;', $markdownLine );

		return $markdownLine;

	}

}

?>