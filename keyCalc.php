<?php

function hex2str($hex) {
	$str = "";
    for($i=0;$i<strlen($hex);$i+=2)
       $str .= chr(hexdec(substr($hex,$i,2)));
    return $str;
}

function bin2text($bin_str) { 
    $text_str = ''; 
    $chars = explode("\n", chunk_split(str_replace("\n", '', $bin_str), 8)); 
    for($i = 0; $i < count($chars)-1; $i++)
		$text_str .= chr(bindec($chars[$i]));
    return $text_str;
} 

function rotate($text, $n, $letters) {
	$alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
    $n = (int)$n % 26;
    if (!$n) return $text;
    if ($n < 0) $n += 26;
    $rep = substr($alphabet, $n * 2) . substr($alphabet, 0, $n * 2);
    return strtr($text, $letters, $rep);
}

function atbashFunc($text) {
	$alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
	$alphabetBack = 'ZzYyXxWwVvUuTtSsRrQqPpOoNnMmLlKkJjIiHhGgFfEeDdCcBbAa';
    return strtr($text, $alphabet, $alphabetBack);
}

function encodeRight($text){
	$isUTF8 = preg_match('//u', $text);
	if($isUTF8 == 1)
		return $text;
	else return utf8_encode($text);
}

function initLetters($key){
	$alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
	if($key !== false){
		$key = preg_replace('/[^A-Za-z\-]/', '', $key);
		$upperKey = strtoupper($key);
		$lowerKey = strtolower($key);
		for($i = strlen($key)-1; $i >= 0; $i--){
			$alphabet = str_replace($upperKey{$i},"",$alphabet);
			$alphabet = str_replace($lowerKey{$i},"",$alphabet);
			$alphabet = $upperKey{$i}.$lowerKey{$i}.$alphabet;
		}
	}
	return $alphabet;
}

$letters = "";
$aes128 = "";
$aes192 = "";
$aes256 = "";
$tripDES = "";
$blowfish = "";
$cast128 = "";
$cast256 = "";
$serpent = "";
$twofish = "";
$rot1 = "";$rot2 = "";$rot3 = "";$rot4 = "";$rot5 = "";$rot6 = "";
$rot7 = "";$rot8 = "";$rot9 = "";$rot10 = "";$rot11 = "";$rot12 = "";
$rot13 = "";$rot14 = "";$rot15 = "";$rot16 = "";$rot17 = "";$rot18 = "";
$rot19 = "";$rot20 = "";$rot21 = "";$rot22 = "";$rot23 = "";$rot24 = "";
$rot25 = "";
$rotArray = array();

$encText = $_POST['encryptedText'];
$key = $_POST['key'];
$base64 = utf8_encode(base64_decode($encText));
$bin = utf8_encode(bin2text($encText));
$hex = utf8_encode(hex2str($encText));
$atbash = utf8_encode(atbashFunc($encText));

if($key){
	$aes128 = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key , base64_decode($encText) , "ecb");
	$aes192 = mcrypt_decrypt(MCRYPT_RIJNDAEL_192, $key , base64_decode($encText) , "ecb");
	$aes256 = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key , base64_decode($encText) , "ecb");
	$tripDES = mcrypt_decrypt(MCRYPT_3DES, $key , base64_decode($encText) , "ecb");
	$blowfish = mcrypt_decrypt(MCRYPT_BLOWFISH, $key , base64_decode($encText) , "ecb");
	$cast128 = mcrypt_decrypt(MCRYPT_CAST_128, $key , base64_decode($encText) , "ecb");
	$cast256 = mcrypt_decrypt(MCRYPT_CAST_256, $key , base64_decode($encText) , "ecb");
	$serpent = mcrypt_decrypt(MCRYPT_SERPENT, $key , base64_decode($encText) , "ecb");
	$twofish = mcrypt_decrypt(MCRYPT_TWOFISH, $key , base64_decode($encText) , "ecb");
	$aes128 = encodeRight($aes128); $aes192 = encodeRight($aes192); $aes256 = encodeRight($aes256);
	$tripDES = encodeRight($tripDES); $blowfish = encodeRight($blowfish); $cast128 = encodeRight($cast128);
	$cast256 = encodeRight($cast256); $serpent = encodeRight($serpent); $twofish = encodeRight($twofish);
	
	$letters = initLetters($key);
} else {
	$letters = initLetters(false);
}

for($i = 1; $i <= 25; $i++){
		$rotArray[$i-1] =  rotate($encText, -$i, $letters);
}

$arr = array ('binary'=>$bin, 'hex'=>$hex, 'atbash'=>$atbash, 'aes128'=>$aes128, 'aes192'=>$aes192,
			'tripDES'=>$tripDES, 'blowfish'=>$blowfish, 'cast128'=>$cast128, 'cast256'=>$cast256, 
			'serpent'=>$serpent, 'twofish'=>$twofish, 'aes256'=>$aes256, 'rot1'=>$rotArray[0],
			'rot2'=>$rotArray[1], 'rot3'=>$rotArray[2], 'rot4'=>$rotArray[3], 'rot5'=>$rotArray[4], 'rot6'=>$rotArray[5], 'rot7'=>$rotArray[6],
			'rot8'=>$rotArray[7], 'rot9'=>$rotArray[8], 'rot10'=>$rotArray[9], 'rot11'=>$rotArray[10], 'rot12'=>$rotArray[11], 'rot13'=>$rotArray[12],
			'rot14'=>$rotArray[13], 'rot15'=>$rotArray[14], 'rot16'=>$rotArray[15], 'rot17'=>$rotArray[16], 'rot18'=>$rotArray[17], 'rot19'=>$rotArray[18],
			'rot20'=>$rotArray[19], 'rot21'=>$rotArray[20], 'rot22'=>$rotArray[21], 'rot23'=>$rotArray[22], 'rot24'=>$rotArray[23], 'rot25'=>$rotArray[24]);

echo json_encode($arr);

?>