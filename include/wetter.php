<?php
if($_SESSION['logged']===true){
	require( DIR_LANGUAGE . PAGE_LANGUAGE . '/wetter' . EXT_CODE );

	$qry = mysql_query("SELECT temp,wetter FROM game_wetter WHERE id=1");
	$ab = mysql_fetch_array($qry);

	$vars['wetter']=array('{WETTER_ICON}'=>$ab['wetter'],'{WETTER_TEMP}'=>$ab['temp'],"{WETTER_TOPIC}"=>$LANG['game']['wetter']['topic'],"{WETTER_TEMPERAUR}"=> date("H:i") . ' Uhr | ' . $LANG['game']['wetter']['WETTER_TEMPERATUR']);
}

?>