<?php
/**
 * UUID class
 *
 * The following class generates VALID RFC 4122 COMPLIANT
 * Universally Unique IDentifiers (UUID) version 4.
 *
 * UUIDs generated validates using OSSP UUID Tool, and output
 * for named-based UUIDs are exactly the same. This is a pure
 * PHP implementation.
 *
 * @author Andrew Moore
 * @link http://www.php.net/manual/en/function.uniqid.php#94959
 */
class UUID
{

	/**
	 *
	 * Generate v4 UUID
	 *
	 * Version 4 UUIDs are pseudo-random.
	 */
	public static function v4()
	{
		$t = unpack('S8', openssl_random_pseudo_bytes(16));
		// four most significant bits of 3rd group hold version number 4
		$t[3] = $t[3] | 0x4000;
		// two most significant bits of 4th group hold zero and one for variant DCE1.1
		$t[4] = $t[4] | 0x8000;
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', ...$t);
	}

	public static function is_valid($uuid) {
		return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
	}
}
?>
