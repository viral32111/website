<?php

// https://www.php.net/manual/en/book.gnupg.php

class PGP {

	// This only works for clear-signed messages
	public static function StripSignature( string $text ) : array {

		if ( preg_match( '/^-{5}BEGIN PGP SIGNED MESSAGE-{5}\nHash: (\w+)\n\n(.+)\n-{5}BEGIN PGP SIGNATURE-{5}\n\n([\w\/+=\n]+)\n-{5}END PGP SIGNATURE-{5}$/s', $text, $signatureMatch ) === 1 ) {

			$hashAlgorithm = $signatureMatch[ 1 ];
			$messageContent = $signatureMatch[ 2 ];
			$signatureBase64 = $signatureMatch[ 3 ];

			return [ $messageContent, true ];

		}

		return [ $text, false ];

	}

}

?>
