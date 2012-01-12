<?
define(ACCOUNT,	  "anon.fm");
define(PREFIX,	  "/imgs/skype_");
define(SKYPE_ON,  "on.gif");
define(SKYPE_DND, "off.gif");
define(SKYPE_NA,  "off.gif");
define(SKYPE_OFF, "off.gif");

$s = array(
	502 => SKYPE_ON,	// chat
	428 => SKYPE_ON,	// online
	546 => SKYPE_DND,	// away
	490 => SKYPE_DND, 	// dnd
	500 => SKYPE_NA,	// na
	376 => SKYPE_OFF	// offline
);

$h = get_headers("http://mystatus.skype.com/smallicon/".ACCOUNT);
$d = "Content-Length: ";
foreach($h as $header) {
  if (strpos(strtolower($header), strtolower($d)) !== false) {
	$len = intval(substr($header, strlen($d)));
	$status = $s[$len];
  }
}

if (!isset($status)) {
	// wtf
	$status = SKYPE_OFF;
}

header("Content-Type: image/gif");

if (file_exists(dirname(__FILE__) . PREFIX . $status)) {
	echo file_get_contents(dirname(__FILE__) . PREFIX . $status);
} else {
	$img = imagecreatetruecolor(142,111);
	$bg = imagecolorallocate($img, 238, 238, 238);
	$txt = imagecolorallocate($img, 0, 0, 255);
	imagefill($img, 0, 0, $bg);
	imagestring($img, 3, 1, 1, "Proebalsya file", $txt);
	imagestring($img, 3, 1, 12, PREFIX.$status, $txt);
	imagegif($img);
}
?>
