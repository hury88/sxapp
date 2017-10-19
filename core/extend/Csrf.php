<?php
class Csrf
{
	public static function get()
	{
		// Config::set('referer_url', $_SERVER['HTTP_REFERER']);
		//
		return $_SESSION['csrf'] = bin2hex(self::crypto_rand_secure(32));
	}

	/**
	 * Prevents Cross-Site Scripting Forgery
	 * @return boolean
	 */
	public static function verify() {
		if( isset($_GET['csrf']) && $_GET['csrf'] == $_SESSION['csrf'] ) {
			return true;
		}
		if( isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf'] ) {
			return true;
		}
		return false;
	}

	public static function crypto_rand_secure($length)
	{
		if(function_exists('openssl_random_pseudo_bytes')) {
			return openssl_random_pseudo_bytes($length);
		} else {
		   $validCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		   $myKeeper = '';
		   for ($n = 1; $n < $length; $n++) {
		      $whichCharacter = mt_rand(0, strlen($validCharacters)-1);
		      $myKeeper .= $validCharacters{$whichCharacter};
		   }
		   return $myKeeper;
		}
	}

}
