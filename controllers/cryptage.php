<?php

echo hash('ripemd160',$Password);
echo ;

$key="ZmzjdzjhfeiHFijzoefjizf78645=0epz+";
$nonce="4Hjefk=jo54f6he6g6tf5sOPJDBS+PHY23";

$ciphertext = sodium_crypto_secretbox("Hello World !", $nonce, $key);

$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
if ($plaintext === false) {
    throw new Exception("Bad ciphertext");
}

echo $plaintext;

static private function _b64encodeSafe($value) {
		$data = base64_encode($value);
		$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

		return $data;
	}


?>