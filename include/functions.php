<?php

function checkFRekord($rekord, $usertime) {
    $ret = 2;
    if(!empty($rekord)) {
        $old = explode('.', round($rekord, 3));
        $new = explode('.', round($usertime, 3));
        if($new[0] < $old[0]) {
            $ret = 1;
        } elseif($new[0] == $old[0]) {
            if($new[1] < $old[1]) { $ret = 1; }
        } elseif($new[0] == $old[0]) {
            if($new[1] == $old[1]) { $ret = 2; }
        } else {
            $ret = 0;
        }
    } else { $ret = 1; }
    return $ret;
}

function loadTemplate($path, $file, $ext) {
    $fullname = $path . $file . $ext;
    if(file_exists($fullname)) {
        $opened = fopen($fullname, "rb");
        while (!feof($opened)) { $out .= fgets($opened, 4096); }
        fclose($opened);
        return $out;
    } else
        return false;
}

function array2text($text, $array) {
    for($x=0;$x!=count($array);$x++) {
        $tmp = each($array);
        $text = str_replace($tmp['key'], $tmp['value'], $text);
    }
    return $text;
}

function checkFormdata() {
    global $HTTP_POST_VARS;
    global $HTTP_GET_VARS;
    $out = array();
    if(isset($HTTP_POST_VARS)){
        while (list($key, $val) = each($HTTP_POST_VARS)){
            if(is_array($val)) {
                while (list($key1, $val1) = each($val)){
                    $out[strtolower($key)][strtolower($key1)] = htmlspecialchars($val1);
                }
            } else {
                $out[strtolower($key)] = htmlspecialchars($val);
            }
        }
    }
    if(isset($HTTP_GET_VARS)){
        while (list($key, $val) = each($HTTP_GET_VARS)){
            if(is_array($val)) {
                while (list($key1, $val1) = each($val)){
                    $out[strtolower($key)][strtolower($key1)] = htmlspecialchars($val1);
                }
            } else {
                $out[strtolower($key)] = htmlspecialchars($val);
            }
        }
    }
    return $out;
}

function createPasswort($lenght) {
    $chars = array(     'a', 'b', 'c', 'd', 'e', 'f', 'g',
                        'h', 'i', 'j', 'k', 'l', 'm', 'n',
                        'o', 'p', 'q', 'r', 's', 't', 'u',
                        'v', 'w', 'x', 'y', 'z', '1', '2',
                        '3', '4', '5', '6', '7', '8', '9'   );
    $passwort = "";
    for($x=0;$x<=$lenght;$x++) {
        srand((double)microtime()*123654789);
        $char = rand(0, count($chars)-1);
        $passwort .= $chars[$char];
    }
    return $passwort;
}

function makeThumbnail($originalfilepath, $thumbnailfilepath, $new_width) {
    $o_info = getimagesize($originalfilepath);
    $o_img_w = $o_info[0];
    $o_img_h = $o_info[1];
    if(@imagecreatefrompng($originalfilepath)) {$o_img = @imagecreatefrompng($originalfilepath);}
    if(@imagecreatefromjpeg($originalfilepath)) {$o_img = @imagecreatefromjpeg($originalfilepath);}
    if(@imagecreatefromgif($originalfilepath)) {$o_img = @imagecreatefromgif($originalfilepath);}
    $n_img_w = $new_width;
    $n_img_h = intval($o_img_h * $n_img_w / $o_img_w);
    $n_img = imagecreatetruecolor($n_img_w, $n_img_h);
    @imagecopyresized($n_img, $o_img, 0, 0, 0, 0, $n_img_w, $n_img_h, $o_img_w, $o_img_h);
    if(imagejpeg($n_img, $thumbnailfilepath, 100)) { return true; } else { return false; }
}

function giveHeight($bild, $breite) {
    if(file_exists($bild)) {
        $info = getimagesize($bild);
        return intval($info[1] * $breite / $info[0]);
    } else {
        return false;
    }
}

function checkEmail($email) {
    $tmp = explode('@', $email);
    if(count($tmp) == 2) {
        $tmp = explode('.', $tmp[1]);
        if(count($tmp) == 2) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function gibDauer($sec) {
    $min = 0;
    while($sec >= 60) { $min++; $sec -= 60; }
    $zeit = 'ca. ' . $min . 'm ' . round($sec, 0) . 's';
    return $zeit;
}

function getZeit($sec) {
    $min = 0;
    while($sec >= 60) { $min++; $sec -= 60; }
    $zeit = $min . 'm ' . round($sec, 2) . 's';
    return $zeit;
}

/*
function tuning_aufsplitte($array){
    $new_array = array();
    $tmp = explode("#", $array);
    for($x=0;$x!=count($tmp);$x++) {
        $info = explode(";", $tmp[$x]);
        $new_array[$x]['teil'] = $info[0];
        $new_array[$x]['schaden'] = $info[1];
    }
    return $new_array;
}


function tuning_zusammnesetzen($a){
	$ar=NULL;
	for($i=0;$i<count($a);$i++){
		$ar.=$a[$i]['teil'].";".$a[$i]['schaden']."#";
	}
	return $ar;
}
*/

?>
