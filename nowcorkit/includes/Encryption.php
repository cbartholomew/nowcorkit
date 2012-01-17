<?
/***********************************************************************
* Encryption.php
* Author		: Christopher Bartholomew
* Last Updated  : 12/08/2011
* Purpose		: Encryption Object
**********************************************************************/

class Encryption
{
		
		public $session_id 		= NULL;
		public $plain_text		= NULL;
		public $cipher_text 	= NULL;
		public $iv_size			= NULL;
		public $iv				= NULL;
		public $key				= NULL;
		public $base64_encode	= NULL;
		public $base64_decode	= NULL;
		
		/*
		 * __construct($_DATA) 
		 * Contructs a encrypted object based on the input object data
		 */
	    function __construct($input) 
		{
			$this->plain_text 	= $input["plain"];
			$this->cipher_text 	= $input["cipher"];
			$this->key 	   	  	= APP_SECRET;			
		}
		
		/*
		 * function encrypt()
		 *
		 */
		function encrypt()
		{
			srand();
			$this->iv_size   	= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$this->iv 	   		= mcrypt_create_iv($this->iv_size, MCRYPT_RAND);
			$this->cipher_text 	= mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->key, $this->plain_text, MCRYPT_MODE_ECB, $this->iv);			
		}
		
		/*
		 * function decrypt()
		 *
		 */
		function decrypt()
		{
				srand();
			$this->iv_size 		= mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$this->iv 	   		= mcrypt_create_iv($this->iv_size, MCRYPT_RAND);
			$this->plain_text 	= mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->key, $this->cipher_text, MCRYPT_MODE_ECB, $this->iv);
		}
	
		/*
		 * function base64_encode()
		 *
		 */	
		function base64_encode()
		{
			$this->base64_encode =  base64_encode($this->cipher_text);			
		}
		
		/*
		 * function base64_decode()
		 *
		 */
		function base64_decode()
		{		
			$this->base64_decode = base64_decode($this->cipher_text);			
		}
}
?>