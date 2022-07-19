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

			// Block-level (only one can be applied per line)
			[ $markdownLine, $headingChange ] = self::ConvertHeading( $markdownLine );
			[ $markdownLine, $unorderedListChange ] = self::ConvertUnorderedList( $markdownLine, $followingLines, $precedingLines );
			// TODO: Ordered List
			// TODO: Table
			[ $markdownLine, $codeBlockChange, $skipLines ] = self::ConvertCodeBlock( $markdownLine, $followingLines );

			if ( empty( $markdownLine ) ) continue;

			// Inline-level (many can be applied per line)
			$markdownLine = self::ConvertStyling( $markdownLine );

			if ( $headingChange || $unorderedListChange || $codeBlockChange ) {
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

	private static function ConvertCodeBlock( string $markdownLine, array $followingLines ) : array {

		if ( strncmp( $markdownLine, "```", 3 ) === 0 ) {

			$language = trim( substr( $markdownLine, 3 ) ); // Its okay if this is empty

			for ( $followingLineNumber = 0; $followingLineNumber < count( $followingLines ); $followingLineNumber++ ) {

				$followingLine = $followingLines[ $followingLineNumber ];

				if ( $followingLine === "```" ) {

					$codeLines = array_slice( $followingLines, 0, $followingLineNumber );
					$code = join( "\n", $codeLines );

					$code = self::EscapeTagSymbols( $code );

					return [ "<pre><code" . ( !empty( $language ) ? " class=\"language-$language\">$code" : "" ) . "</code></pre>", true, count( $codeLines ) + 2 ];

				}

			}

			throw new Exception( "Code block never ends." );

		}

		return [ $markdownLine, false, 0 ];

	}
	
	private static function ConvertStyling( string $markdownLine ) : string {
	
		// Bold
		$markdownLine = preg_replace( '/\*\*(.+?)\*\*/', '<strong>${1}</strong>', $markdownLine );
	
		// Italic
		$markdownLine = preg_replace( '/\*(.+?)\*/', '<em>${1}</em>', $markdownLine );
	
		// Code
		$markdownLine = preg_replace( '/`(.+?)`/', '<code>${1}</code>', $markdownLine );
	
		// Links
		$markdownLine = preg_replace( '/\[(.+?)\]\((.+?)\)/', '<a href="${2}">${1}</a>', $markdownLine );
	
		return $markdownLine;
	
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